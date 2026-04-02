<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerGroupController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BillerController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\AdjustmentController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\ReturnPurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\GiftCardController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\MoneyTransferController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\StockCountController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\CashRegisterController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CurrencyController;

/*
|--------------------------------------------------------------------------
| Inertia Routes (from clinova starter kit)
|--------------------------------------------------------------------------
*/
Route::inertia('welcome', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('welcome');

/*
|--------------------------------------------------------------------------
| Inventory Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard']);
});

Route::middleware(['auth', 'active'])->group(function () {

    Route::get('/', [HomeController::class, 'index']);
    Route::get('/dashboard-filter/{start_date}/{end_date}', [HomeController::class, 'dashboardFilter']);

    Route::get('language_switch/{locale}', [LanguageController::class, 'switchLanguage']);

    Route::get('role/permission/{id}', [RoleController::class, 'permission'])->name('role.permission');
    Route::post('role/set_permission', [RoleController::class, 'setPermission'])->name('role.setPermission');
    Route::resource('role', RoleController::class);

    Route::post('importunit', [UnitController::class, 'importUnit'])->name('unit.import');
    Route::post('unit/deletebyselection', [UnitController::class, 'deleteBySelection']);
    Route::get('unit/lims_unit_search', [UnitController::class, 'limsUnitSearch'])->name('unit.search');
    Route::resource('unit', UnitController::class);

    Route::post('category/import', [CategoryController::class, 'import'])->name('category.import');
    Route::post('category/deletebyselection', [CategoryController::class, 'deleteBySelection']);
    Route::post('category/category-data', [CategoryController::class, 'categoryData']);
    Route::resource('category', CategoryController::class);

    Route::post('importbrand', [BrandController::class, 'importBrand'])->name('brand.import');
    Route::post('brand/deletebyselection', [BrandController::class, 'deleteBySelection']);
    Route::get('brand/lims_brand_search', [BrandController::class, 'limsBrandSearch'])->name('brand.search');
    Route::resource('brand', BrandController::class);

    Route::post('importsupplier', [SupplierController::class, 'importSupplier'])->name('supplier.import');
    Route::post('supplier/deletebyselection', [SupplierController::class, 'deleteBySelection']);
    Route::get('supplier/lims_supplier_search', [SupplierController::class, 'limsSupplierSearch'])->name('supplier.search');
    Route::resource('supplier', SupplierController::class);

    Route::post('importwarehouse', [WarehouseController::class, 'importWarehouse'])->name('warehouse.import');
    Route::post('warehouse/deletebyselection', [WarehouseController::class, 'deleteBySelection']);
    Route::get('warehouse/lims_warehouse_search', [WarehouseController::class, 'limsWarehouseSearch'])->name('warehouse.search');
    Route::resource('warehouse', WarehouseController::class);

    Route::post('importtax', [TaxController::class, 'importTax'])->name('tax.import');
    Route::post('tax/deletebyselection', [TaxController::class, 'deleteBySelection']);
    Route::get('tax/lims_tax_search', [TaxController::class, 'limsTaxSearch'])->name('tax.search');
    Route::resource('tax', TaxController::class);

    // Products
    Route::post('products/product-data', [ProductController::class, 'productData']);
    Route::get('products/gencode', [ProductController::class, 'generateCode']);
    Route::get('products/search', [ProductController::class, 'search']);
    Route::get('products/saleunit/{id}', [ProductController::class, 'saleUnit']);
    Route::get('products/getdata/{id}', [ProductController::class, 'getData']);
    Route::get('products/product_warehouse/{id}', [ProductController::class, 'productWarehouseData']);
    Route::post('importproduct', [ProductController::class, 'importProduct'])->name('product.import');
    Route::post('exportproduct', [ProductController::class, 'exportProduct'])->name('product.export');
    Route::get('products/print_barcode', [ProductController::class, 'printBarcode'])->name('product.printBarcode');
    Route::get('products/lims_product_search', [ProductController::class, 'limsProductSearch'])->name('product.search');
    Route::post('products/deletebyselection', [ProductController::class, 'deleteBySelection']);
    Route::post('products/update', [ProductController::class, 'updateProduct']);
    Route::resource('products', ProductController::class);

    // Customer Groups
    Route::post('importcustomer_group', [CustomerGroupController::class, 'importCustomerGroup'])->name('customer_group.import');
    Route::post('customer_group/deletebyselection', [CustomerGroupController::class, 'deleteBySelection']);
    Route::get('customer_group/lims_customer_group_search', [CustomerGroupController::class, 'limsCustomerGroupSearch'])->name('customer_group.search');
    Route::resource('customer_group', CustomerGroupController::class);

    // Customers
    Route::post('importcustomer', [CustomerController::class, 'importCustomer'])->name('customer.import');
    Route::get('customer/getDeposit/{id}', [CustomerController::class, 'getDeposit']);
    Route::post('customer/add_deposit', [CustomerController::class, 'addDeposit'])->name('customer.addDeposit');
    Route::post('customer/update_deposit', [CustomerController::class, 'updateDeposit'])->name('customer.updateDeposit');
    Route::post('customer/deleteDeposit', [CustomerController::class, 'deleteDeposit'])->name('customer.deleteDeposit');
    Route::post('customer/deletebyselection', [CustomerController::class, 'deleteBySelection']);
    Route::get('customer/lims_customer_search', [CustomerController::class, 'limsCustomerSearch'])->name('customer.search');
    Route::resource('customer', CustomerController::class);

    // Billers
    Route::post('importbiller', [BillerController::class, 'importBiller'])->name('biller.import');
    Route::post('biller/deletebyselection', [BillerController::class, 'deleteBySelection']);
    Route::get('biller/lims_biller_search', [BillerController::class, 'limsBillerSearch'])->name('biller.search');
    Route::resource('biller', BillerController::class);

    // Sales
    Route::post('sales/sale-data', [SaleController::class, 'saleData']);
    Route::post('sales/sendmail', [SaleController::class, 'sendMail'])->name('sale.sendmail');
    Route::get('sales/sale_by_csv', [SaleController::class, 'saleByCsv']);
    Route::get('sales/product_sale/{id}', [SaleController::class, 'productSaleData']);
    Route::post('importsale', [SaleController::class, 'importSale'])->name('sale.import');
    Route::get('pos', [SaleController::class, 'posSale'])->name('sale.pos');
    Route::get('sales/lims_sale_search', [SaleController::class, 'limsSaleSearch'])->name('sale.search');
    Route::get('sales/lims_product_search', [SaleController::class, 'limsProductSearch'])->name('product_sale.search');
    Route::get('sales/getcustomergroup/{id}', [SaleController::class, 'getCustomerGroup'])->name('sale.getcustomergroup');
    Route::get('sales/getproduct/{id}', [SaleController::class, 'getProduct'])->name('sale.getproduct');
    Route::get('sales/getproduct/{category_id}/{brand_id}', [SaleController::class, 'getProductByFilter']);
    Route::get('sales/getfeatured', [SaleController::class, 'getFeatured']);
    Route::get('sales/get_gift_card', [SaleController::class, 'getGiftCard']);
    Route::get('sales/paypalSuccess', [SaleController::class, 'paypalSuccess']);
    Route::get('sales/paypalPaymentSuccess/{id}', [SaleController::class, 'paypalPaymentSuccess']);
    Route::get('sales/gen_invoice/{id}', [SaleController::class, 'genInvoice'])->name('sale.invoice');
    Route::post('sales/add_payment', [SaleController::class, 'addPayment'])->name('sale.add-payment');
    Route::get('sales/getpayment/{id}', [SaleController::class, 'getPayment'])->name('sale.get-payment');
    Route::post('sales/updatepayment', [SaleController::class, 'updatePayment'])->name('sale.update-payment');
    Route::post('sales/deletepayment', [SaleController::class, 'deletePayment'])->name('sale.delete-payment');
    Route::get('sales/{id}/create', [SaleController::class, 'createSale']);
    Route::post('sales/deletebyselection', [SaleController::class, 'deleteBySelection']);
    Route::get('sales/print-last-reciept', [SaleController::class, 'printLastReciept'])->name('sales.printLastReciept');
    Route::get('sales/today-sale', [SaleController::class, 'todaySale']);
    Route::get('sales/today-profit/{warehouse_id}', [SaleController::class, 'todayProfit']);
    Route::resource('sales', SaleController::class);

    // Deliveries
    Route::get('delivery', [DeliveryController::class, 'index'])->name('delivery.index');
    Route::get('delivery/product_delivery/{id}', [DeliveryController::class, 'productDeliveryData']);
    Route::get('delivery/create/{id}', [DeliveryController::class, 'create']);
    Route::post('delivery/store', [DeliveryController::class, 'store'])->name('delivery.store');
    Route::post('delivery/sendmail', [DeliveryController::class, 'sendMail'])->name('delivery.sendMail');
    Route::get('delivery/{id}/edit', [DeliveryController::class, 'edit']);
    Route::post('delivery/update', [DeliveryController::class, 'update'])->name('delivery.update');
    Route::post('delivery/deletebyselection', [DeliveryController::class, 'deleteBySelection']);
    Route::post('delivery/delete/{id}', [DeliveryController::class, 'delete'])->name('delivery.delete');

    // Quotations
    Route::get('quotations/product_quotation/{id}', [QuotationController::class, 'productQuotationData']);
    Route::get('quotations/lims_product_search', [QuotationController::class, 'limsProductSearch'])->name('product_quotation.search');
    Route::get('quotations/getcustomergroup/{id}', [QuotationController::class, 'getCustomerGroup'])->name('quotation.getcustomergroup');
    Route::get('quotations/getproduct/{id}', [QuotationController::class, 'getProduct'])->name('quotation.getproduct');
    Route::get('quotations/{id}/create_sale', [QuotationController::class, 'createSale'])->name('quotation.create_sale');
    Route::get('quotations/{id}/create_purchase', [QuotationController::class, 'createPurchase'])->name('quotation.create_purchase');
    Route::post('quotations/sendmail', [QuotationController::class, 'sendMail'])->name('quotation.sendmail');
    Route::post('quotations/deletebyselection', [QuotationController::class, 'deleteBySelection']);
    Route::resource('quotations', QuotationController::class);

    // Purchases
    Route::post('purchases/purchase-data', [PurchaseController::class, 'purchaseData']);
    Route::get('purchases/product_purchase/{id}', [PurchaseController::class, 'productPurchaseData']);
    Route::get('purchases/lims_product_search', [PurchaseController::class, 'limsProductSearch'])->name('product_purchase.search');
    Route::post('purchases/add_payment', [PurchaseController::class, 'addPayment'])->name('purchase.add-payment');
    Route::get('purchases/getpayment/{id}', [PurchaseController::class, 'getPayment'])->name('purchase.get-payment');
    Route::post('purchases/updatepayment', [PurchaseController::class, 'updatePayment'])->name('purchase.update-payment');
    Route::post('purchases/deletepayment', [PurchaseController::class, 'deletePayment'])->name('purchase.delete-payment');
    Route::get('purchases/purchase_by_csv', [PurchaseController::class, 'purchaseByCsv']);
    Route::post('importpurchase', [PurchaseController::class, 'importPurchase'])->name('purchase.import');
    Route::post('purchases/deletebyselection', [PurchaseController::class, 'deleteBySelection']);
    Route::resource('purchases', PurchaseController::class);

    // Transfers
    Route::get('transfers/product_transfer/{id}', [TransferController::class, 'productTransferData']);
    Route::get('transfers/transfer_by_csv', [TransferController::class, 'transferByCsv']);
    Route::post('importtransfer', [TransferController::class, 'importTransfer'])->name('transfer.import');
    Route::get('transfers/getproduct/{id}', [TransferController::class, 'getProduct'])->name('transfer.getproduct');
    Route::get('transfers/lims_product_search', [TransferController::class, 'limsProductSearch'])->name('product_transfer.search');
    Route::post('transfers/deletebyselection', [TransferController::class, 'deleteBySelection']);
    Route::resource('transfers', TransferController::class);

    // Adjustments
    Route::get('qty_adjustment/getproduct/{id}', [AdjustmentController::class, 'getProduct'])->name('adjustment.getproduct');
    Route::get('qty_adjustment/lims_product_search', [AdjustmentController::class, 'limsProductSearch'])->name('product_adjustment.search');
    Route::post('qty_adjustment/deletebyselection', [AdjustmentController::class, 'deleteBySelection']);
    Route::resource('qty_adjustment', AdjustmentController::class);

    // Return Sales
    Route::get('return-sale/getcustomergroup/{id}', [ReturnController::class, 'getCustomerGroup'])->name('return-sale.getcustomergroup');
    Route::post('return-sale/sendmail', [ReturnController::class, 'sendMail'])->name('return-sale.sendmail');
    Route::get('return-sale/getproduct/{id}', [ReturnController::class, 'getProduct'])->name('return-sale.getproduct');
    Route::get('return-sale/lims_product_search', [ReturnController::class, 'limsProductSearch'])->name('product_return-sale.search');
    Route::get('return-sale/product_return/{id}', [ReturnController::class, 'productReturnData']);
    Route::post('return-sale/deletebyselection', [ReturnController::class, 'deleteBySelection']);
    Route::resource('return-sale', ReturnController::class);

    // Return Purchases
    Route::get('return-purchase/getcustomergroup/{id}', [ReturnPurchaseController::class, 'getCustomerGroup'])->name('return-purchase.getcustomergroup');
    Route::post('return-purchase/sendmail', [ReturnPurchaseController::class, 'sendMail'])->name('return-purchase.sendmail');
    Route::get('return-purchase/getproduct/{id}', [ReturnPurchaseController::class, 'getProduct'])->name('return-purchase.getproduct');
    Route::get('return-purchase/lims_product_search', [ReturnPurchaseController::class, 'limsProductSearch'])->name('product_return-purchase.search');
    Route::get('return-purchase/product_return/{id}', [ReturnPurchaseController::class, 'productReturnData']);
    Route::post('return-purchase/deletebyselection', [ReturnPurchaseController::class, 'deleteBySelection']);
    Route::resource('return-purchase', ReturnPurchaseController::class);

    // Reports
    Route::get('report/product_quantity_alert', [ReportController::class, 'productQuantityAlert'])->name('report.qtyAlert');
    Route::get('report/warehouse_stock', [ReportController::class, 'warehouseStock'])->name('report.warehouseStock');
    Route::post('report/warehouse_stock', [ReportController::class, 'warehouseStockById'])->name('report.warehouseStock');
    Route::get('report/daily_sale/{year}/{month}', [ReportController::class, 'dailySale']);
    Route::post('report/daily_sale/{year}/{month}', [ReportController::class, 'dailySaleByWarehouse'])->name('report.dailySaleByWarehouse');
    Route::get('report/monthly_sale/{year}', [ReportController::class, 'monthlySale']);
    Route::post('report/monthly_sale/{year}', [ReportController::class, 'monthlySaleByWarehouse'])->name('report.monthlySaleByWarehouse');
    Route::get('report/daily_purchase/{year}/{month}', [ReportController::class, 'dailyPurchase']);
    Route::post('report/daily_purchase/{year}/{month}', [ReportController::class, 'dailyPurchaseByWarehouse'])->name('report.dailyPurchaseByWarehouse');
    Route::get('report/monthly_purchase/{year}', [ReportController::class, 'monthlyPurchase']);
    Route::post('report/monthly_purchase/{year}', [ReportController::class, 'monthlyPurchaseByWarehouse'])->name('report.monthlyPurchaseByWarehouse');
    Route::get('report/best_seller', [ReportController::class, 'bestSeller']);
    Route::post('report/best_seller', [ReportController::class, 'bestSellerByWarehouse'])->name('report.bestSellerByWarehouse');
    Route::post('report/profit_loss', [ReportController::class, 'profitLoss'])->name('report.profitLoss');
    Route::post('report/product_report', [ReportController::class, 'productReport'])->name('report.product');
    Route::post('report/purchase', [ReportController::class, 'purchaseReport'])->name('report.purchase');
    Route::post('report/sale_report', [ReportController::class, 'saleReport'])->name('report.sale');
    Route::post('report/payment_report_by_date', [ReportController::class, 'paymentReportByDate'])->name('report.paymentByDate');
    Route::post('report/warehouse_report', [ReportController::class, 'warehouseReport'])->name('report.warehouse');
    Route::post('report/user_report', [ReportController::class, 'userReport'])->name('report.user');
    Route::post('report/customer_report', [ReportController::class, 'customerReport'])->name('report.customer');
    Route::post('report/supplier', [ReportController::class, 'supplierReport'])->name('report.supplier');
    Route::post('report/due_report_by_date', [ReportController::class, 'dueReportByDate'])->name('report.dueByDate');

    // Users
    Route::get('user/profile/{id}', [UserController::class, 'profile'])->name('user.profile');
    Route::put('user/update_profile/{id}', [UserController::class, 'profileUpdate'])->name('user.profileUpdate');
    Route::put('user/changepass/{id}', [UserController::class, 'changePassword'])->name('user.password');
    Route::get('user/genpass', [UserController::class, 'generatePassword']);
    Route::post('user/deletebyselection', [UserController::class, 'deleteBySelection']);
    Route::resource('user', UserController::class);

    // Settings
    Route::get('setting/general_setting', [SettingController::class, 'generalSetting'])->name('setting.general');
    Route::post('setting/general_setting_store', [SettingController::class, 'generalSettingStore'])->name('setting.generalStore');
    Route::get('backup', [SettingController::class, 'backup'])->name('setting.backup');
    Route::get('setting/general_setting/change-theme/{theme}', [SettingController::class, 'changeTheme']);
    Route::get('setting/mail_setting', [SettingController::class, 'mailSetting'])->name('setting.mail');
    Route::get('setting/sms_setting', [SettingController::class, 'smsSetting'])->name('setting.sms');
    Route::get('setting/createsms', [SettingController::class, 'createSms'])->name('setting.createSms');
    Route::post('setting/sendsms', [SettingController::class, 'sendSms'])->name('setting.sendSms');
    Route::get('setting/hrm_setting', [SettingController::class, 'hrmSetting'])->name('setting.hrm');
    Route::post('setting/hrm_setting_store', [SettingController::class, 'hrmSettingStore'])->name('setting.hrmStore');
    Route::post('setting/mail_setting_store', [SettingController::class, 'mailSettingStore'])->name('setting.mailStore');
    Route::post('setting/sms_setting_store', [SettingController::class, 'smsSettingStore'])->name('setting.smsStore');
    Route::get('setting/pos_setting', [SettingController::class, 'posSetting'])->name('setting.pos');
    Route::post('setting/pos_setting_store', [SettingController::class, 'posSettingStore'])->name('setting.posStore');
    Route::get('setting/empty-database', [SettingController::class, 'emptyDatabase'])->name('setting.emptyDatabase');

    // Expense Categories
    Route::get('expense_categories/gencode', [ExpenseCategoryController::class, 'generateCode']);
    Route::post('expense_categories/import', [ExpenseCategoryController::class, 'import'])->name('expense_category.import');
    Route::post('expense_categories/deletebyselection', [ExpenseCategoryController::class, 'deleteBySelection']);
    Route::resource('expense_categories', ExpenseCategoryController::class);

    // Expenses
    Route::post('expenses/deletebyselection', [ExpenseController::class, 'deleteBySelection']);
    Route::resource('expenses', ExpenseController::class);

    // Gift Cards
    Route::get('gift_cards/gencode', [GiftCardController::class, 'generateCode']);
    Route::post('gift_cards/recharge/{id}', [GiftCardController::class, 'recharge'])->name('gift_cards.recharge');
    Route::post('gift_cards/deletebyselection', [GiftCardController::class, 'deleteBySelection']);
    Route::resource('gift_cards', GiftCardController::class);

    // Coupons
    Route::get('coupons/gencode', [CouponController::class, 'generateCode']);
    Route::post('coupons/deletebyselection', [CouponController::class, 'deleteBySelection']);
    Route::resource('coupons', CouponController::class);

    // Accounting
    Route::get('accounts/make-default/{id}', [AccountsController::class, 'makeDefault']);
    Route::get('accounts/balancesheet', [AccountsController::class, 'balanceSheet'])->name('accounts.balancesheet');
    Route::post('accounts/account-statement', [AccountsController::class, 'accountStatement'])->name('accounts.statement');
    Route::resource('accounts', AccountsController::class);
    Route::resource('money-transfers', MoneyTransferController::class);

    // HRM
    Route::post('departments/deletebyselection', [DepartmentController::class, 'deleteBySelection']);
    Route::resource('departments', DepartmentController::class);

    Route::post('employees/deletebyselection', [EmployeeController::class, 'deleteBySelection']);
    Route::resource('employees', EmployeeController::class);

    Route::post('payroll/deletebyselection', [PayrollController::class, 'deleteBySelection']);
    Route::resource('payroll', PayrollController::class);

    Route::post('attendance/deletebyselection', [AttendanceController::class, 'deleteBySelection']);
    Route::resource('attendance', AttendanceController::class);

    // Stock Count
    Route::resource('stock-count', StockCountController::class);
    Route::post('stock-count/finalize', [StockCountController::class, 'finalize'])->name('stock-count.finalize');
    Route::get('stock-count/stockdif/{id}', [StockCountController::class, 'stockDif']);
    Route::get('stock-count/{id}/qty_adjustment', [StockCountController::class, 'qtyAdjustment'])->name('stock-count.adjustment');

    // Holidays
    Route::post('holidays/deletebyselection', [HolidayController::class, 'deleteBySelection']);
    Route::get('approve-holiday/{id}', [HolidayController::class, 'approveHoliday'])->name('approveHoliday');
    Route::get('holidays/my-holiday/{year}/{month}', [HolidayController::class, 'myHoliday'])->name('myHoliday');
    Route::resource('holidays', HolidayController::class);

    // Cash Register
    Route::get('cash-register', [CashRegisterController::class, 'index'])->name('cashRegister.index');
    Route::get('cash-register/check-availability/{warehouse_id}', [CashRegisterController::class, 'checkAvailability'])->name('cashRegister.checkAvailability');
    Route::post('cash-register/store', [CashRegisterController::class, 'store'])->name('cashRegister.store');
    Route::get('cash-register/getDetails/{id}', [CashRegisterController::class, 'getDetails']);
    Route::get('cash-register/showDetails/{warehouse_id}', [CashRegisterController::class, 'showDetails']);
    Route::post('cash-register/close', [CashRegisterController::class, 'close'])->name('cashRegister.close');

    // Notifications
    Route::post('notifications/store', [NotificationController::class, 'store'])->name('notifications.store');
    Route::get('notifications/mark-as-read', [NotificationController::class, 'markAsRead']);

    // Currency
    Route::resource('currency', CurrencyController::class);

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('my-transactions/{year}/{month}', [HomeController::class, 'myTransaction']);
});

require __DIR__.'/settings.php';
