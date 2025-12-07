<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LeadRemarkController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CostComponentController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\IncentiveRuleController;
use App\Http\Controllers\IncentiveController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.auth');
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'check.active'])->group(function () {

    Route::get('/', function () {
        return redirect()->route('reports.index');
    })->name('home');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // users routes restricted to admin/HR only
    Route::middleware('permission:view users')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users');
    });
    
    Route::middleware('permission:create users')->group(function () {
        Route::post('/user/store', [UserController::class, 'store'])->name('users.store');
    });
    
    Route::middleware('permission:edit users')->group(function () {
        Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/user/update', [UserController::class, 'update'])->name('users.update');
    });
    
    Route::middleware('permission:delete users')->group(function () {
        Route::get('/user/delete/{id}', [UserController::class, 'destroy'])->name('users.delete');
    });

    // Services
    Route::middleware('permission:view services')->group(function () {
        Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    });
    Route::middleware('permission:create services')->group(function () {
        Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
        Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    });
    Route::middleware('permission:edit services')->group(function () {
        Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
        Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    });
    Route::middleware('permission:delete services')->group(function () {
        Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
    });
    Route::middleware('permission:view services')->group(function () {
        Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
    });

    // Destinations
    Route::middleware('permission:view destinations')->group(function () {
        Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
    });
    Route::middleware('permission:create destinations')->group(function () {
        Route::get('/destinations/create', [DestinationController::class, 'create'])->name('destinations.create');
        Route::post('/destinations', [DestinationController::class, 'store'])->name('destinations.store');
    });
    Route::middleware('permission:edit destinations')->group(function () {
        Route::get('/destinations/{destination}/edit', [DestinationController::class, 'edit'])->name('destinations.edit');
        Route::put('/destinations/{destination}', [DestinationController::class, 'update'])->name('destinations.update');
    });
    Route::middleware('permission:delete destinations')->group(function () {
        Route::delete('/destinations/{destination}', [DestinationController::class, 'destroy'])->name('destinations.destroy');
    });
    Route::middleware('permission:view destinations')->group(function () {
        Route::get('/destinations/{destination}', [DestinationController::class, 'show'])->name('destinations.show');
    });

    // Leads routes - IMPORTANT: Specific routes must come before wildcard routes
    Route::middleware('permission:view leads')->group(function () {
        Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
        Route::get('/bookings', [LeadController::class, 'bookings'])->name('bookings.index');
    });
    Route::middleware('permission:create leads')->group(function () {
        Route::get('/leads/create', [LeadController::class, 'create'])->name('leads.create');
        Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');
    });
    Route::middleware('permission:edit leads')->group(function () {
        Route::get('/leads/{lead}/edit', [LeadController::class, 'edit'])->name('leads.edit');
        Route::put('/leads/{lead}', [LeadController::class, 'update'])->name('leads.update');
        Route::get('/bookings/{lead}/form', [LeadController::class, 'bookingForm'])->name('bookings.form');
    });
    Route::middleware('permission:view leads')->group(function () {
        Route::get('/leads/{lead}', [LeadController::class, 'show'])->name('leads.show');
    });
    Route::middleware('permission:update lead status')->group(function () {
        Route::post('/leads/{lead}/status', [LeadController::class, 'updateStatus'])->name('leads.updateStatus');
    });
    Route::middleware('permission:edit leads')->group(function () {
        Route::post('/leads/{lead}/assign-user', [LeadController::class, 'updateAssignedUser'])->name('leads.updateAssignedUser');
        Route::post('/leads/bulk-assign', [LeadController::class, 'bulkAssign'])->name('leads.bulkAssign');
    });
    Route::middleware('permission:delete leads')->group(function () {
        Route::delete('/leads/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');
    });

    // Lead Remarks
    Route::middleware('permission:view remarks')->group(function () {
        Route::get('/leads/{lead}/remarks', [LeadRemarkController::class, 'index'])->name('leads.remarks.index');
    });
    Route::middleware('permission:create remarks')->group(function () {
        Route::post('/leads/{lead}/remarks', [LeadRemarkController::class, 'store'])->name('leads.remarks.store');
    });
    Route::middleware('permission:edit remarks')->group(function () {
        Route::put('/leads/{lead}/remarks/{remark}', [LeadRemarkController::class, 'update'])->name('leads.remarks.update');
    });
    Route::middleware('permission:delete remarks')->group(function () {
        Route::delete('/leads/{lead}/remarks/{remark}', [LeadRemarkController::class, 'destroy'])->name('leads.remarks.destroy');
    });

    // Accounts & Payments
    Route::middleware('permission:view payments')->group(function () {
        Route::get('/accounts', [PaymentController::class, 'index'])->name('accounts.index');
        Route::get('/api/accounts/dashboard', [PaymentController::class, 'dashboard'])->name('api.accounts.dashboard');
        Route::get('/api/accounts/leads', [PaymentController::class, 'leads'])->name('api.accounts.leads');
        Route::get('/api/accounts/export', [PaymentController::class, 'export'])->name('api.accounts.export');
    });
    Route::middleware('permission:view payments')->group(function () {
        Route::get('/leads/{lead}/payments', [PaymentController::class, 'show'])->name('leads.payments.index');
    });
    Route::middleware('permission:create payments')->group(function () {
        Route::post('/leads/{lead}/payments', [PaymentController::class, 'store'])->name('leads.payments.store');
        Route::post('/api/accounts/{lead}/add-payment', [PaymentController::class, 'addPayment'])->name('api.accounts.add-payment');
    });
    Route::middleware('permission:edit payments')->group(function () {
        Route::put('/leads/{lead}/payments/{payment}', [PaymentController::class, 'update'])->name('leads.payments.update');
    });
    Route::middleware('permission:delete payments')->group(function () {
        Route::delete('/leads/{lead}/payments/{payment}', [PaymentController::class, 'destroy'])->name('leads.payments.destroy');
    });

    // Cost Components
    Route::middleware('permission:view costs')->group(function () {
        Route::get('/leads/{lead}/cost-components', [CostComponentController::class, 'index'])->name('leads.cost-components.index');
    });
    Route::middleware('permission:create costs')->group(function () {
        Route::post('/leads/{lead}/cost-components', [CostComponentController::class, 'store'])->name('leads.cost-components.store');
        Route::post('/api/accounts/{lead}/add-cost', [CostComponentController::class, 'addCost'])->name('api.accounts.add-cost');
    });
    Route::middleware('permission:edit costs')->group(function () {
        Route::put('/leads/{lead}/cost-components/{costComponent}', [CostComponentController::class, 'update'])->name('leads.cost-components.update');
    });
    Route::middleware('permission:delete costs')->group(function () {
        Route::delete('/leads/{lead}/cost-components/{costComponent}', [CostComponentController::class, 'destroy'])->name('leads.cost-components.destroy');
    });

    // Operations
    Route::middleware('permission:view operations')->group(function () {
        Route::get('/operations', [OperationController::class, 'index'])->name('operations.index');
    });
    Route::middleware('permission:create operations')->group(function () {
        Route::post('/leads/{lead}/operations', [OperationController::class, 'store'])->name('leads.operations.store');
    });
    Route::middleware('permission:edit operations')->group(function () {
        Route::put('/leads/{lead}/operations/{operation}', [OperationController::class, 'update'])->name('leads.operations.update');
    });
    Route::middleware('permission:approve operations')->group(function () {
        Route::post('/leads/{lead}/operations/{operation}/approve', [OperationController::class, 'approve'])->name('leads.operations.approve');
        Route::post('/leads/{lead}/operations/{operation}/reject', [OperationController::class, 'reject'])->name('leads.operations.reject');
    });

    // Post Sales & Documents
    Route::middleware('permission:view documents')->group(function () {
        Route::get('/post-sales', [DocumentController::class, 'index'])->name('post-sales.index');
        Route::get('/leads/{lead}/documents', [DocumentController::class, 'show'])->name('leads.documents.index');
        Route::get('/leads/{lead}/documents/{document}/download', [DocumentController::class, 'download'])->name('leads.documents.download');
    });
    Route::middleware('permission:upload documents')->group(function () {
        Route::post('/leads/{lead}/documents', [DocumentController::class, 'store'])->name('leads.documents.store');
        Route::put('/leads/{lead}/documents/bulk-update', [DocumentController::class, 'bulkUpdate'])->name('leads.documents.bulk-update');
    });
    Route::middleware('permission:verify documents')->group(function () {
        Route::put('/leads/{lead}/documents/{document}', [DocumentController::class, 'update'])->name('leads.documents.update');
    });
    Route::middleware('permission:delete documents')->group(function () {
        Route::delete('/leads/{lead}/documents/{document}', [DocumentController::class, 'destroy'])->name('leads.documents.destroy');
    });

    // Deliveries
    Route::middleware('permission:view deliveries')->group(function () {
        Route::get('/deliveries', [DeliveryController::class, 'index'])->name('deliveries.index');
    });
    Route::middleware('permission:view deliveries')->group(function () {
        Route::get('/leads/{lead}/deliveries', [DeliveryController::class, 'show'])->name('leads.deliveries.index');
    });
    Route::middleware('permission:assign deliveries')->group(function () {
        Route::post('/leads/{lead}/deliveries', [DeliveryController::class, 'store'])->name('leads.deliveries.store');
    });
    Route::middleware('permission:update deliveries')->group(function () {
        Route::put('/leads/{lead}/deliveries/{delivery}', [DeliveryController::class, 'update'])->name('leads.deliveries.update');
        Route::post('/leads/{lead}/deliveries/{delivery}/upload', [DeliveryController::class, 'upload'])->name('leads.deliveries.upload');
    });

    // Delivery API Routes
    Route::prefix('api/delivery')->middleware(['auth:sanctum'])->group(function () {
        Route::get('/', [DeliveryController::class, 'apiIndex'])->name('api.delivery.index');
        Route::post('/{delivery}/assign', [DeliveryController::class, 'assign'])->middleware('permission:assign deliveries')->name('api.delivery.assign');
        Route::put('/{delivery}/status', [DeliveryController::class, 'updateStatus'])->middleware('permission:update deliveries')->name('api.delivery.update-status');
        Route::post('/{delivery}/upload-files', [DeliveryController::class, 'uploadFiles'])->middleware('permission:update deliveries')->name('api.delivery.upload-files');
        Route::get('/export', [DeliveryController::class, 'export'])->middleware('permission:export reports')->name('api.delivery.export');
    });

    // Destination API Routes
    Route::get('/api/destinations/{destination}/locations', [DestinationController::class, 'getLocations'])->name('api.destinations.locations');

    // Incentives
    Route::middleware('permission:view incentives')->group(function () {
        Route::get('/incentives', [IncentiveController::class, 'index'])->name('incentives.index');
    });
    Route::middleware('permission:calculate incentives')->group(function () {
        Route::post('/leads/{lead}/incentives/calculate', [IncentiveController::class, 'calculate'])->name('leads.incentives.calculate');
    });
    Route::middleware('permission:approve incentives')->group(function () {
        Route::post('/incentives/{incentive}/approve', [IncentiveController::class, 'approve'])->name('incentives.approve');
    });
    Route::middleware('permission:mark incentives paid')->group(function () {
        Route::post('/incentives/{incentive}/mark-paid', [IncentiveController::class, 'markPaid'])->name('incentives.markPaid');
    });

    // Incentive Rules (Admin only)
    Route::middleware('permission:view incentive rules')->group(function () {
        Route::get('/incentive-rules', [IncentiveRuleController::class, 'index'])->name('incentive-rules.index');
    });
    Route::middleware('permission:create incentive rules')->group(function () {
        Route::get('/incentive-rules/create', [IncentiveRuleController::class, 'create'])->name('incentive-rules.create');
        Route::post('/incentive-rules', [IncentiveRuleController::class, 'store'])->name('incentive-rules.store');
    });
    Route::middleware('permission:edit incentive rules')->group(function () {
        Route::get('/incentive-rules/{incentiveRule}/edit', [IncentiveRuleController::class, 'edit'])->name('incentive-rules.edit');
        Route::put('/incentive-rules/{incentiveRule}', [IncentiveRuleController::class, 'update'])->name('incentive-rules.update');
    });
    Route::middleware('permission:delete incentive rules')->group(function () {
        Route::delete('/incentive-rules/{incentiveRule}', [IncentiveRuleController::class, 'destroy'])->name('incentive-rules.destroy');
    });

    // Reports
    Route::middleware('permission:view reports')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/leads', [ReportController::class, 'leads'])->name('reports.leads');
        Route::get('/reports/revenue', [ReportController::class, 'revenue'])->name('reports.revenue');
        Route::get('/reports/profit', [ReportController::class, 'profit'])->name('reports.profit');
    });
    Route::middleware('permission:export reports')->group(function () {
        Route::get('/reports/export/leads', [ReportController::class, 'exportLeads'])->name('reports.export.leads');
    });
});
