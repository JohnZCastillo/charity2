<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Charity\AboutController;
use App\Http\Controllers\Charity\AnnouncementController as CharityAnnouncementController;
use App\Http\Controllers\Charity\ContactController;
use App\Http\Controllers\Charity\EventController as CharityEventController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Inventory\AccountController;
use App\Http\Controllers\Inventory\DonorController;
use App\Http\Controllers\Inventory\ExpenseController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RecipientController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\AboutContentController;
use App\Http\Controllers\FormBuilderController;
use App\Http\Controllers\HomeContentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\NavigationContentController;
use Illuminate\Support\Facades\Route;





Route::prefix('inventory')->middleware(['auth'])->group(function () {

    Route::post('/login', [AuthController::class, 'login'])
        ->withoutMiddleware(['auth']);

    Route::get('/login', [AuthController::class, 'index'])
        ->withoutMiddleware(['auth'])
        ->name('login');



    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/items', [ItemController::class, 'index']);
    Route::get('/items/{item}', [ItemController::class, 'viewItem']);

    Route::post('/stock-in', [ItemController::class, 'addStock']);

    Route::post('/donate-expense', [ExpenseController::class, 'donate']);
    Route::post('/expense', [ExpenseController::class, 'expense']);

    Route::get('/donors', [DonorController::class, 'index']);
    Route::get('/donors/{donorID}', [DonorController::class, 'getDonor'])->name('donor.get');
    Route::post('/donor/update/{donorID}', [DonorController::class, 'updateDonor'])->name('donor.update');
    Route::delete('/donor/{donorID}', [DonorController::class, 'deleteDonor'])->name('donor.delete');
    Route::post('/donor/add', [DonorController::class, 'addDonor'])->name('donor.add');

    Route::get('/account', [AccountController::class, 'index']);
    Route::post('/account', [AccountController::class, 'updateAccount']);
    Route::patch('/account', [AccountController::class, 'updatePassword']);

    Route::get('/recipients', [RecipientController::class, 'index']);
    Route::get('/recipients/{recipientID}', [RecipientController::class, 'getRecipient'])->name('recipient.get');
    Route::patch('/recipients/{recipientID}', [RecipientController::class, 'updateRecipient']);
    Route::post('/recipient', [RecipientController::class, 'addRecipient'])->name('recipient.add');
    Route::delete('/recipient/{recipientID}', [RecipientController::class, 'deleteRecipient'])->name('recipient.delete');

    Route::get('/announcement/{announcementID}', [AnnouncementController::class, 'viewAnnouncement']);
    Route::patch('/announcement/{announcementID}', [AnnouncementController::class, 'updateAnnouncement']);
    Route::delete('/announcement/{announcementID}', [AnnouncementController::class, 'deleteAnnouncement']);

    Route::get('/report', [\App\Http\Controllers\Inventory\ReportController::class, 'report']);
    Route::post('/recipient-report', [\App\Http\Controllers\Inventory\ReportController::class, 'index']);

    Route::post('/event', [\App\Http\Controllers\Inventory\EventController::class, 'newEvent']);
    Route::get('/events', [\App\Http\Controllers\Inventory\EventController::class, 'index']);
    Route::get('/events/{eventID}', [\App\Http\Controllers\Inventory\EventController::class, 'viewEvent']);
    Route::delete('/events/{eventID}', [\App\Http\Controllers\Inventory\EventController::class, 'deleteEvent']);
    Route::patch('/events/{eventID}', [\App\Http\Controllers\Inventory\EventController::class, 'updateEvent']);

    Route::delete('/event-image/{eventImage}', [\App\Http\Controllers\Inventory\EventImageController::class, 'deleteImage']);

    Route::post('/appointments', [\App\Http\Controllers\Inventory\AppointmentController::class, 'appoint'])
        ->withoutMiddleware(['auth']);

    Route::get('/appointments', [\App\Http\Controllers\Inventory\AppointmentController::class, 'index']);
    Route::get('/appointment-slot', [\App\Http\Controllers\Inventory\AppointmentController::class, 'appointmentSlot']);
    Route::post('/appointment-slot', [\App\Http\Controllers\Inventory\AppointmentController::class, 'addSlot']);
    Route::delete('/appointment-slot', [\App\Http\Controllers\Inventory\AppointmentController::class, 'updateSlot']);

    Route::post('/appointments/reschedule', [\App\Http\Controllers\Inventory\AppointmentController::class, 'sendReschedule'])
     ->name('appointments.reschedule');

    Route::post('/appointments/{id}/confirm', [\App\Http\Controllers\Inventory\AppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::post('/appointments/{id}/done', [\App\Http\Controllers\Inventory\AppointmentController::class, 'done'])->name('appointments.done');
    Route::post('/appointments/{id}/undone', [\App\Http\Controllers\Inventory\AppointmentController::class, 'undone'])->name('appointments.undone');

    Route::post('/appointments/cancel', [\App\Http\Controllers\Inventory\AppointmentController::class, 'sendCancelled'])
     ->name('appointments.cancel');


    Route::post('/block-appointment-slot', [\App\Http\Controllers\Inventory\AppointmentController::class, 'addBlockSlot']);

    Route::post('/donate', [\App\Http\Controllers\DonationController::class, 'donate']);
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements');

    Route::get('/inquiries', [\App\Http\Controllers\Inventory\InquiryController::class, 'index']);
    Route::post('/inquiries', [\App\Http\Controllers\Inventory\InquiryController::class, 'inquire']);
    Route::post('/inquiries/reply', [App\Http\Controllers\Inventory\InquiryController::class, 'reply'])->name('inquiries.reply');
    Route::post('/inquiries/{id}/read', [App\Http\Controllers\Inventory\InquiryController::class, 'markAsRead'])->name('inquiries.read');
    Route::delete('/inquiries/{inquiry}', [App\Http\Controllers\Inventory\InquiryController::class, 'destroy'])->name('inquiries.destroy');




    Route::get('/users', [\App\Http\Controllers\Inventory\UserController::class, 'index']);
    Route::post('/users', [\App\Http\Controllers\Inventory\UserController::class, 'addUser']);
    Route::post('/users/archived/{user}', [\App\Http\Controllers\Inventory\UserController::class, 'archivedUser']);
    Route::post('/users/unarchived/{user}', [\App\Http\Controllers\Inventory\UserController::class, 'unArchivedUser']);

    Route::post('/donate-fund', [\App\Http\Controllers\Inventory\DonationDriveController::class, 'donate']);

    Route::get('/donation-drive', [\App\Http\Controllers\Inventory\DonationDriveController::class, 'index'])->name('donationdrive.index');
    Route::get('/donation-drive/{donationDriveID}', [\App\Http\Controllers\Inventory\DonationDriveController::class, 'donationDriveData']);
    Route::post('/donation/confirm', [\App\Http\Controllers\Inventory\DonationDriveController::class, 'confirm'])->name('donation.confirm');
    Route::post('/donation/amount', [\App\Http\Controllers\Inventory\DonationDriveController::class, 'amount'])->name('donation.amount');

    Route::post('/donation-drive', [\App\Http\Controllers\Inventory\DonationDriveController::class, 'add']);
    Route::patch('/donation-drive/{donationDrive}', [\App\Http\Controllers\Inventory\DonationDriveController::class, 'update']);
    Route::delete('/donation-drive/{donationDrive}', [\App\Http\Controllers\Inventory\DonationDriveController::class, 'delete']);

    Route::patch('/donations/{id}/status', [\App\Http\Controllers\Inventory\DonationDriveController::class, 'updateStatus'])
    ->name('donations.updateStatus');
    //donation drive report
    Route::get('/donation-drive/{id}/report', [\App\Http\Controllers\Inventory\DonationDriveController::class, 'report'])->name('donations-drive.report');

    Route::patch('/navigation-content/{id}', [NavigationContentController::class,'update'])
        ->name('navigation-content.update');

    Route::get('/activity-logs', [ActivityLogController::class,'index'])->name('activity-logs.index');
    Route::delete('/activity-logs/{id}', [ActivityLogController::class,'destroy'])->name('activity-logs.destroy');
    
    // Editor
    Route::get('/editor', [EditorController::class, 'index']);
    Route::patch('/cms/home', [EditorController::class, 'update'])->name('home.cms.update');
    Route::post('/about/reorder', [AboutContentController::class, 'reorder'])->name('about.reorder');

    Route::post('/admin/home/qr-code/update', [HomeContentController::class, 'updateQrCode'])->name('home.qr.update');


    //FORM BUILDER 
    Route::get('/form/list', [FormBuilderController::class, 'index'])->name('form-builder.index');
    Route::get('/form-generator', [FormBuilderController::class, 'create'])->name('form-builder.create');
    Route::post('/post/form-builder', [FormBuilderController::class, 'store'])->name('form-builder.store');
    Route::post('/store', [FormBuilderController::class, 'store'])->name('form-builder.submit');
    Route::get('/{form}', [FormBuilderController::class, 'show'])->name('form-builder.show');
    Route::delete('/form-builder/{id}', [FormBuilderController::class, 'destroy'])->name('form-builder.destroy');

    Route::get('/{form}/edit', [FormBuilderController::class, 'edit'])->name('form-builder.edit'); // EDIT route
    Route::put('/{form}/update', [FormBuilderController::class, 'update'])->name('form-builder.update'); // UPDATE route
    
    //USER RESPONSE VIEWER
    Route::get('/form-builder/{id}/responses', [FormBuilderController::class, 'responses'])->name('form-builder.responses');

});
    

// fFOR PUBLIC FORM GENERATED BY THE ADMIN TO BE FILLED UP BY RESPONDENTS
Route::get('/form/{id}', [FormBuilderController::class, 'publicShow'])->name('form.public.show');
//OUTSIDE CLIENT FORM SUBMIT
Route::post('/form-builder/{id}/submit', [FormBuilderController::class, 'submit'])->name('form-builder.submission');


// CMS About routes - accessible at /cms/about
Route::prefix('cms/about')->middleware(['auth'])->group(function () {
    Route::post('/', [AboutContentController::class, 'store'])->name('about.store');
    Route::post('/{id}', [AboutContentController::class, 'update'])->name('about.update');
    Route::delete('/{id}', [AboutContentController::class, 'destroy'])->name('about.destroy');
   // Route::post('/reorder', [AboutContentController::class, 'reorder'])->name('about.reorder');
});

Route::get('/', [HomeController::class, 'index']);
Route::get('/donor-logs/fetch', [HomeController::class, 'fetchDonorLogs'])->name('donor.logs.fetch');


//TEST PAYMONGO
Route::get('/charity/pay', [PaymentController::class, 'index'])->name('payment.index');
Route::post('/charity/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
// Success redirect (after payment)
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');

// Cancel redirect (after cancel)
Route::get('/payment/cancel', function () {
    return view('paymongo.cancel');
})->name('payment.cancel');

// Webhook (PayMongo will POST here)
Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');


//========================//
Route::prefix('charity')->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/announcements', [CharityAnnouncementController::class, 'index']);
    Route::get('/announcements/view/{id}',[AnnouncementController::class, 'view'])->name('announcements.show');
    Route::get('/contact-us', [ContactController::class, 'index']);
    Route::get('/about-us', [AboutController::class, 'index']);
    Route::get('/events', [CharityEventController::class, 'index'])->name('events.index');
    Route::get('/events/view/{id}', [\App\Http\Controllers\Charity\EventController::class, 'view'])->name('events.show');
    Route::get('/appointment', [\App\Http\Controllers\Charity\AppointmentController::class, 'index']);

    Route::get('/donate', [\App\Http\Controllers\Charity\DonateController::class, 'donateView']);
    Route::post('/check-donate', [\App\Http\Controllers\Charity\DonateController::class, 'check']);
    Route::post('/donate', [\App\Http\Controllers\Charity\DonateController::class, 'index']);
});

Route::get('/api/slot/{date}', [\App\Http\Controllers\APIController::class, 'slot']);
Route::patch('/item/{item}', [ItemController::class, 'updateItem']);
Route::post('/donor', [DonorController::class, 'addDonor']);

Route::post('/item', [ItemController::class, 'addItem']);
Route::delete('/item/{item}', [ItemController::class, 'deleteItem']);
Route::post('/announcement', [AnnouncementController::class, 'newAnnouncement']);
Route::post('/announcement-attachment', [\App\Http\Controllers\AnnouncementAttachmentController::class, 'addImage']);
Route::get('/create-announcement', [AnnouncementController::class, 'createAnnouncement']);
Route::get('/report', [\App\Http\Controllers\Inventory\ReportController::class, 'testReport']);

