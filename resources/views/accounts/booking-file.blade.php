@extends('layouts.app')
@section('title', 'Account Booking File | Travel Shravel')
@section('content')
    <div class="hk-pg-wrapper pb-0">
        <div class="hk-pg-body py-0">
            <div class="contactapp-wrap">
                <div class="contactapp-content">
                    <div class="contactapp-detail-wrap">
                        <header class="contact-header">
                            <div class="w-100 align-items-center justify-content-between d-flex contactapp-title link-dark">
                                <div>
                                    <h1>Booking File - {{ $lead->tsq }}</h1>
                                    <small class="text-muted">{{ $lead->customer_name }}</small>
                                </div>
                                <div>
                                    <a href="{{ route('accounts.index') }}" class="btn btn-secondary btn-sm">
                                        <i data-feather="arrow-left" style="width: 14px; height: 14px;"></i>
                                        Back to Accounts
                                    </a>
                                </div>
                            </div>
                        </header>

                        <div class="contact-body">
                            <div data-simplebar class="nicescroll-bar">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>There were some problems with your submission:</strong>
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                @php
                                    $isViewOnly = $isViewOnly ?? true;
                                    $disabledAttr = $isViewOnly ? 'readonly disabled' : '';
                                    $disabledStyle = $isViewOnly
                                        ? 'style="background-color: #f8f9fa; cursor: not-allowed;"'
                                        : '';
                                @endphp

                                <!-- Customer Details Section -->
                                <div class="mb-4 border rounded-3 p-3">
                                    <h6 class="text-uppercase text-muted small fw-semibold mb-3">
                                        <i data-feather="user" class="me-1" style="width: 14px; height: 14px;"></i>
                                        Customer Details
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Ref No.</label>
                                            <input type="text" value="{{ $lead->tsq }}"
                                                class="form-control form-control-sm" readonly disabled
                                                style="background-color: #f8f9fa; cursor: not-allowed;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Salutation</label>
                                            <input type="text" value="{{ $lead->salutation ?? '' }}"
                                                class="form-control form-control-sm" readonly disabled
                                                style="background-color: #f8f9fa; cursor: not-allowed;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">First Name</label>
                                            <input type="text" value="{{ $lead->first_name }}"
                                                class="form-control form-control-sm" readonly disabled
                                                style="background-color: #f8f9fa; cursor: not-allowed;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" value="{{ $lead->last_name ?? '' }}"
                                                class="form-control form-control-sm" readonly disabled
                                                style="background-color: #f8f9fa; cursor: not-allowed;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Primary No.</label>
                                            <input type="text" value="{{ $lead->primary_phone ?? $lead->phone }}"
                                                class="form-control form-control-sm" readonly disabled
                                                style="background-color: #f8f9fa; cursor: not-allowed;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Secondary No.</label>
                                            <input type="text" value="{{ $lead->secondary_phone ?? '' }}"
                                                class="form-control form-control-sm" readonly disabled
                                                style="background-color: #f8f9fa; cursor: not-allowed;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Emergency No.</label>
                                            <input type="text" value="{{ $lead->other_phone ?? '' }}"
                                                class="form-control form-control-sm" readonly disabled
                                                style="background-color: #f8f9fa; cursor: not-allowed;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Email ID</label>
                                            <input type="email" value="{{ $lead->email }}"
                                                class="form-control form-control-sm" readonly disabled
                                                style="background-color: #f8f9fa; cursor: not-allowed;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">No. of Adult(s)</label>
                                            <input type="number" value="{{ $lead->adults }}"
                                                class="form-control form-control-sm" readonly disabled
                                                style="background-color: #f8f9fa; cursor: not-allowed;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Child (2-5 years)</label>
                                            <input type="number" value="{{ $lead->children_2_5 ?? 0 }}"
                                                class="form-control form-control-sm" readonly disabled
                                                style="background-color: #f8f9fa; cursor: not-allowed;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Child (6-11 years)</label>
                                            <input type="number" value="{{ $lead->children_6_11 ?? 0 }}"
                                                class="form-control form-control-sm" readonly disabled
                                                style="background-color: #f8f9fa; cursor: not-allowed;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Infant (>2 years)</label>
                                            <input type="number" value="{{ $lead->infants ?? 0 }}"
                                                class="form-control form-control-sm" readonly disabled
                                                style="background-color: #f8f9fa; cursor: not-allowed;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Travel Date</label>
                                            <input type="text"
                                                value="{{ $lead->travel_date ? $lead->travel_date->format('d M, Y') : 'N/A' }}"
                                                class="form-control form-control-sm" readonly disabled
                                                style="background-color: #f8f9fa; cursor: not-allowed;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Return Date</label>
                                            <input type="text"
                                                value="{{ $lead->return_date ? $lead->return_date->format('d M, Y') : 'N/A' }}"
                                                class="form-control form-control-sm" readonly disabled
                                                style="background-color: #f8f9fa; cursor: not-allowed;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Booked On</label>
                                            <input type="text"
                                                value="{{ $lead->booked_on ? $lead->booked_on->format('d M, Y h:i A') : 'N/A' }}"
                                                class="form-control form-control-sm" readonly disabled
                                                style="background-color: #f8f9fa; cursor: not-allowed;">
                                        </div>
                                        @php
                                            $paymentState = $customerPaymentState ?? 'none';
                                            $salesBgColor = '#f8f9fa';
                                            $salesBorderColor = '#ced4da';
                                            $paymentIcon = null;
                                            $paymentIconColor = '#6c757d';

                                            if ($paymentState === 'full') {
                                                $salesBgColor = '#d4edda'; // green
                                                $salesBorderColor = '#28a745';
                                                $paymentIcon = 'check-circle';
                                                $paymentIconColor = '#28a745';
                                            } elseif ($paymentState === 'partial') {
                                                $salesBgColor = '#fff3cd'; // yellow
                                                $salesBorderColor = '#ffc107';
                                                $paymentIcon = 'clock';
                                                $paymentIconColor = '#ffc107';
                                            } else {
                                                $salesBgColor = '#f8d7da'; // red
                                                $salesBorderColor = '#dc3545';
                                                $paymentIcon = 'alert-circle';
                                                $paymentIconColor = '#dc3545';
                                            }
                                        @endphp
                                        <div class="col-md-3">
                                            <label class="form-label">Sales Cost</label>
                                            <div class="input-group input-group-sm">
                                                <input type="text"
                                                    value="{{ $lead->selling_price ? number_format($lead->selling_price, 2) : '0.00' }}"
                                                    class="form-control form-control-sm" readonly disabled
                                                    style="background-color: {{ $salesBgColor }}; cursor: not-allowed; border-color: {{ $salesBorderColor }};">
                                                @if($paymentIcon)
                                                    <span class="input-group-text" style="background-color: {{ $salesBgColor }}; border-color: {{ $salesBorderColor }};">
                                                        <i data-feather="{{ $paymentIcon }}" style="width: 14px; height: 14px; color: {{ $paymentIconColor }};"></i>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Accounts Summary Box Section -->
                                <div class="mb-4 border rounded-3 p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="text-uppercase text-muted small fw-semibold mb-0">
                                            <i data-feather="file-text" class="me-1" style="width: 14px; height: 14px;"></i>
                                            Accounts Summary Box
                                        </h6>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addAccountSummaryModal">
                                            <i data-feather="plus" style="width: 14px; height: 14px;"></i>
                                            Add
                                        </button>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm mb-0" id="accountsSummaryTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Ref. No.</th>
                                                    <th>Vendor Code/Name</th>
                                                    <th>Vendor Cost</th>
                                                    <th>Paid Amount</th>
                                                    <th>Payment Status</th>
                                                    <th>Referred By or Lead Source</th>
                                                    <th>Sales Cost</th>
                                                    <th>Received Amount</th>
                                                    <th>Payment Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="accountsSummaryTableBody">
                                                @if(isset($accountSummaries) && $accountSummaries->count() > 0)
                                                    @foreach($accountSummaries as $summary)
                                                        <tr data-summary-id="{{ $summary->id }}">
                                                            <td>{{ $summary->ref_no ?? $lead->tsq }}</td>
                                                            <td>{{ $summary->vendor_code ?? '-' }}</td>
                                                            <td>{{ $summary->vendor_cost ? number_format($summary->vendor_cost, 2) : '-' }}</td>
                                                            <td>{{ $summary->paid_amount ? number_format($summary->paid_amount, 2) : '-' }}</td>
                                                            <td>
                                                                <span class="badge bg-{{ $summary->vendor_payment_status == 'Done' ? 'success' : ($summary->vendor_payment_status == 'Pending' ? 'warning' : 'secondary') }}">
                                                                    {{ $summary->vendor_payment_status ?? '-' }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $summary->referred_by ?? '-' }}</td>
                                                            <td>{{ $summary->sales_cost ? number_format($summary->sales_cost, 2) : '-' }}</td>
                                                            <td>{{ $summary->received_amount ? number_format($summary->received_amount, 2) : '-' }}</td>
                                                            <td>
                                                                <span class="badge bg-{{ $summary->customer_payment_status == 'Received' ? 'success' : ($summary->customer_payment_status == 'Pending' ? 'warning' : 'secondary') }}">
                                                                    {{ $summary->customer_payment_status ?? '-' }}
                                                                </span>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-sm btn-outline-primary edit-account-summary-btn" data-summary-id="{{ $summary->id }}" data-bs-toggle="modal" data-bs-target="#addAccountSummaryModal">
                                                                    <i data-feather="edit" style="width: 14px; height: 14px;"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-outline-danger delete-account-summary-btn" data-summary-id="{{ $summary->id }}">
                                                                    <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="10" class="text-center text-muted py-4">No accounts summary data found</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Vendor Payments Section (Accounts - Yellow Part Editable) -->
                                <div class="mb-4 border rounded-3 p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h6 class="text-uppercase text-muted small fw-semibold mb-0">
                                                <i data-feather="dollar-sign" class="me-1" style="width: 14px; height: 14px;"></i>
                                                Vendor Payments (Ops → Accounts)
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm mb-0" id="vendorPaymentsAccountsTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Vendor Code/Name</th>
                                                    <th>Booking Type</th>
                                                    <th>Location</th>
                                                    <th>Purchase Cost</th>
                                                    <th>Due Date</th>
                                                    <th>Paid</th>
                                                    <th>Pending</th>
                                                    <th>Payment Mode</th>
                                                    <th>Ref. No.</th>
                                                    <th>Remarks</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="vendorPaymentsAccountsTableBody">
                                                @if(isset($vendorPayments) && $vendorPayments->count() > 0)
                                                    @foreach($vendorPayments as $vp)
                                                        <tr data-vendor-payment-id="{{ $vp->id }}" data-status="{{ $vp->status ?? 'Pending' }}">
                                                            <td>{{ $vp->vendor_code ?? '-' }}</td>
                                                            <td>{{ $vp->booking_type ?? '-' }}</td>
                                                            <td>{{ $vp->location ?? '-' }}</td>
                                                            <td>{{ $vp->purchase_cost ? number_format($vp->purchase_cost, 2) : '-' }}</td>
                                                            <td>{{ $vp->due_date ? $vp->due_date->format('d/m/Y') : '-' }}</td>
                                                            <td>{{ $vp->paid_amount ? number_format($vp->paid_amount, 2) : '-' }}</td>
                                                            <td>{{ $vp->pending_amount ? number_format($vp->pending_amount, 2) : '-' }}</td>
                                                            <td>{{ $vp->payment_mode ?? '-' }}</td>
                                                            <td>{{ $vp->ref_no ?? '-' }}</td>
                                                            <td>{{ $vp->remarks ?? '-' }}</td>
                                                            <td>
                                                                <span class="badge bg-{{ $vp->status == 'Paid' ? 'success' : ($vp->status == 'Pending' ? 'warning' : 'secondary') }}">
                                                                    {{ $vp->status ?? 'Pending' }}
                                                                </span>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-sm btn-outline-primary edit-vendor-payment-accounts-btn" data-vendor-payment-id="{{ $vp->id }}" data-bs-toggle="modal" data-bs-target="#editVendorPaymentAccountsModal">
                                                                    <i data-feather="edit" style="width: 14px; height: 14px;"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="12" class="text-center text-muted py-4">No vendor payments found</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Customer Payments (View Only for Accounts) -->
                                <div class="mb-4 border rounded-3 p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="text-uppercase text-muted small fw-semibold mb-0">
                                            <i data-feather="credit-card" class="me-1" style="width: 14px; height: 14px;"></i>
                                            Customer Payments (Post Sales → Accounts)
                                        </h6>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Amount</th>
                                                    <th>Method</th>
                                                    <th>Paid On</th>
                                                    <th>Due Date</th>
                                                    <th>Transaction ID</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $payments = $lead->payments ?? collect();
                                                @endphp
                                                @if($payments->count() > 0)
                                                    @foreach($payments as $payment)
                                                        <tr>
                                                            <td>₹{{ number_format($payment->amount, 2) }}</td>
                                                            <td>{{ ucfirst(str_replace('_', ' ', $payment->method)) }}</td>
                                                            <td>{{ $payment->payment_date ? $payment->payment_date->format('d/m/Y') : '-' }}</td>
                                                            <td>{{ $payment->due_date ? $payment->due_date->format('d/m/Y') : '-' }}</td>
                                                            <td>{{ $payment->reference ?? '-' }}</td>
                                                            <td>
                                                                @php
                                                                    $statusColor = $payment->status === 'received' ? 'success' : ($payment->status === 'refunded' ? 'secondary' : 'warning');
                                                                @endphp
                                                                <span class="badge bg-{{ $statusColor }}">
                                                                    {{ ucfirst($payment->status) }}
                                                                </span>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-sm btn-outline-primary edit-customer-payment-btn" 
                                                                    data-payment-id="{{ $payment->id }}"
                                                                    data-amount="{{ $payment->amount }}"
                                                                    data-method="{{ $payment->method }}"
                                                                    data-payment-date="{{ $payment->payment_date ? $payment->payment_date->format('Y-m-d') : '' }}"
                                                                    data-due-date="{{ $payment->due_date ? $payment->due_date->format('Y-m-d') : '' }}"
                                                                    data-reference="{{ $payment->reference }}"
                                                                    data-status="{{ $payment->status }}"
                                                                    data-bs-toggle="modal" data-bs-target="#editCustomerPaymentAccountsModal">
                                                                    <i data-feather="edit" style="width: 14px; height: 14px;"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="7" class="text-center text-muted py-3">No customer payments recorded</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footer')
    </div>

    <!-- Add/Edit Account Summary Modal -->
    <div class="modal fade" id="addAccountSummaryModal" tabindex="-1" aria-labelledby="addAccountSummaryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAccountSummaryModalLabel">Add Account Summary</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addAccountSummaryForm">
                        @csrf
                        <input type="hidden" id="summaryId" name="summary_id" value="">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Ref. No.</label>
                                <input type="text" class="form-control form-control-sm" id="modalRefNo" value="{{ $lead->tsq }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Vendor Code/Name</label>
                                <input type="text" class="form-control form-control-sm" id="modalVendorCode" name="vendor_code" placeholder="Enter vendor code">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Vendor Cost</label>
                                <input type="number" class="form-control form-control-sm" id="modalVendorCost" name="vendor_cost" step="0.01" min="0" placeholder="0.00">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Paid Amount</label>
                                <input type="number" class="form-control form-control-sm" id="modalPaidAmount" name="paid_amount" step="0.01" min="0" placeholder="0.00">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Vendor Payment Status</label>
                                <select class="form-select form-select-sm" id="modalVendorPaymentStatus" name="vendor_payment_status">
                                    <option value="">-- Select --</option>
                                    <option value="Done">Done</option>
                                    <option value="Pending">Pending</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Referred By or Lead Source</label>
                                <input type="text" class="form-control form-control-sm" id="modalReferredBy" name="referred_by" placeholder="Enter referred by">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Sales Cost</label>
                                <input type="number" class="form-control form-control-sm" id="modalSalesCost" name="sales_cost" step="0.01" min="0" value="{{ $lead->selling_price ?? 0 }}" placeholder="0.00">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Received Amount</label>
                                <input type="number" class="form-control form-control-sm" id="modalReceivedAmount" name="received_amount" step="0.01" min="0" placeholder="0.00">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Customer Payment Status</label>
                                <select class="form-select form-select-sm" id="modalCustomerPaymentStatus" name="customer_payment_status">
                                    <option value="">-- Select --</option>
                                    <option value="Received">Received</option>
                                    <option value="Pending">Pending</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="submitAccountSummaryModal">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Vendor Payment Modal (Accounts - Yellow Part Only) -->
    <div class="modal fade" id="editVendorPaymentAccountsModal" tabindex="-1" aria-labelledby="editVendorPaymentAccountsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editVendorPaymentAccountsModalLabel">Edit Vendor Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editVendorPaymentAccountsForm">
                        @csrf
                        <input type="hidden" id="vendorPaymentAccountsId" name="vendor_payment_id" value="">
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Paid Amount</label>
                                <input type="number" class="form-control form-control-sm" id="accountsModalPaidAmount" name="paid_amount" step="0.01" min="0" placeholder="0.00">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pending Amount</label>
                                <input type="number" class="form-control form-control-sm" id="accountsModalPendingAmount" name="pending_amount" step="0.01" min="0" placeholder="0.00">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Payment Mode</label>
                                <select class="form-select form-select-sm" id="accountsModalPaymentMode" name="payment_mode">
                                    <option value="">-- Select --</option>
                                    <option value="Cash">Cash</option>
                                    <option value="UPI">UPI</option>
                                    <option value="NEFT">NEFT</option>
                                    <option value="RTGS">RTGS</option>
                                    <option value="WIB">WIB</option>
                                    <option value="Online">Online</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Ref. No.</label>
                                <input type="text" class="form-control form-control-sm" id="accountsModalRefNo" name="ref_no" placeholder="Payment Reference No.">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" id="accountsModalStatus" name="status" required>
                                    <option value="Paid">Paid</option>
                                    <option value="Pending">Pending</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Remarks</label>
                                <textarea class="form-control form-control-sm" id="accountsModalRemarks" name="remarks" rows="2" placeholder="Enter remarks"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="submitVendorPaymentAccountsModal">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Customer Payment Modal (Accounts) -->
    <div class="modal fade" id="editCustomerPaymentAccountsModal" tabindex="-1" aria-labelledby="editCustomerPaymentAccountsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCustomerPaymentAccountsModalLabel">Edit Customer Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCustomerPaymentAccountsForm">
                        @csrf
                        <input type="hidden" id="customerPaymentAccountsId" name="payment_id" value="">
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Amount <span class="text-danger">*</span></label>
                                <input type="number" class="form-control form-control-sm" id="custModalAmount" name="amount" step="0.01" min="0" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" id="custModalMethod" name="method" required>
                                    <option value="Cash">Cash</option>
                                    <option value="UPI">UPI</option>
                                    <option value="NEFT">NEFT</option>
                                    <option value="RTGS">RTGS</option>
                                    <option value="WIB">WIB</option>
                                    <option value="Online">Online</option>
                                    <option value="Cheque">Cheque</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Paid On <span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm" id="custModalPaymentDate" name="payment_date" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Due Date</label>
                                <input type="date" class="form-control form-control-sm" id="custModalDueDate" name="due_date">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Transaction ID</label>
                                <input type="text" class="form-control form-control-sm" id="custModalReference" name="reference">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" id="custModalStatus" name="status" required>
                                    <option value="pending">Pending</option>
                                    <option value="received">Received</option>
                                    <option value="refunded">Refunded</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="submitCustomerPaymentAccountsModal">Save</button>
                </div>
            </div>
        </div>
    </div>

    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            const leadId = {{ $lead->id }};
            let currentEditSummaryId = null;

            // Initialize feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }

            // Reset modal form
            function resetAccountSummaryModal() {
                document.getElementById('addAccountSummaryForm').reset();
                document.getElementById('summaryId').value = '';
                document.getElementById('modalRefNo').value = '{{ $lead->tsq }}';
                document.getElementById('addAccountSummaryModalLabel').textContent = 'Add Account Summary';
                currentEditSummaryId = null;
            }

            // Handle modal show event
            const addAccountSummaryModal = document.getElementById('addAccountSummaryModal');
            if (addAccountSummaryModal) {
                addAccountSummaryModal.addEventListener('show.bs.modal', function() {
                    resetAccountSummaryModal();
                });
            }

            // Handle edit button click
            document.addEventListener('click', function(e) {
                if (e.target.closest('.edit-account-summary-btn')) {
                    const btn = e.target.closest('.edit-account-summary-btn');
                    const summaryId = btn.dataset.summaryId;
                    const row = btn.closest('tr');
                    
                    currentEditSummaryId = summaryId;
                    document.getElementById('summaryId').value = summaryId;
                    document.getElementById('addAccountSummaryModalLabel').textContent = 'Edit Account Summary';
                    
                    // Populate form with row data
                    document.getElementById('modalRefNo').value = row.cells[0].textContent.trim();
                    document.getElementById('modalVendorCode').value = row.cells[1].textContent.trim() !== '-' ? row.cells[1].textContent.trim() : '';
                    document.getElementById('modalVendorCost').value = row.cells[2].textContent.trim() !== '-' ? row.cells[2].textContent.trim().replace(/[₹,]/g, '') : '';
                    document.getElementById('modalPaidAmount').value = row.cells[3].textContent.trim() !== '-' ? row.cells[3].textContent.trim().replace(/[₹,]/g, '') : '';
                    document.getElementById('modalVendorPaymentStatus').value = row.cells[4].querySelector('.badge') ? row.cells[4].querySelector('.badge').textContent.trim() : '';
                    document.getElementById('modalReferredBy').value = row.cells[5].textContent.trim() !== '-' ? row.cells[5].textContent.trim() : '';
                    document.getElementById('modalSalesCost').value = row.cells[6].textContent.trim() !== '-' ? row.cells[6].textContent.trim().replace(/[₹,]/g, '') : '';
                    document.getElementById('modalReceivedAmount').value = row.cells[7].textContent.trim() !== '-' ? row.cells[7].textContent.trim().replace(/[₹,]/g, '') : '';
                    document.getElementById('modalCustomerPaymentStatus').value = row.cells[8].querySelector('.badge') ? row.cells[8].querySelector('.badge').textContent.trim() : '';
                }
            });

            // Handle form submission
            document.getElementById('submitAccountSummaryModal')?.addEventListener('click', async function() {
                const form = document.getElementById('addAccountSummaryForm');
                const formData = new FormData(form);
                const summaryId = document.getElementById('summaryId').value;
                
                let url = `/accounts/${leadId}/account-summary`;
                let method = 'POST';
                
                if (summaryId) {
                    url = `/accounts/${leadId}/account-summary/${summaryId}`;
                    method = 'PUT';
                    formData.append('_method', 'PUT');
                }

                try {
                    const response = await fetch(url, {
                        method: method === 'PUT' ? 'POST' : method,
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || formData.get('_token')
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || 'Failed to save account summary');
                    }

                    // Close modal and reload page
                    const modal = bootstrap.Modal.getInstance(addAccountSummaryModal);
                    if (modal) {
                        modal.hide();
                    }
                    
                    // Reload page to show updated data
                    window.location.reload();
                } catch (error) {
                    alert(error.message || 'Failed to save account summary');
                }
            });

            // Handle delete button click
            document.addEventListener('click', async function(e) {
                if (e.target.closest('.delete-account-summary-btn')) {
                    const btn = e.target.closest('.delete-account-summary-btn');
                    const summaryId = btn.dataset.summaryId;
                    
                    if (!confirm('Are you sure you want to delete this account summary?')) {
                        return;
                    }

                    try {
                        const response = await fetch(`/accounts/${leadId}/account-summary/${summaryId}`, {
                            method: 'DELETE',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                            }
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(data.message || 'Failed to delete account summary');
                        }

                        // Reload page to show updated data
                        window.location.reload();
                    } catch (error) {
                        alert(error.message || 'Failed to delete account summary');
                    }
                }
            });

            // Re-initialize feather icons when modal is shown
            if (addAccountSummaryModal) {
                addAccountSummaryModal.addEventListener('shown.bs.modal', function() {
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }
                });
            }

            // Vendor Payment Accounts handlers
            let currentEditVendorPaymentId = null;

            // Handle edit vendor payment button click
            document.addEventListener('click', function(e) {
                if (e.target.closest('.edit-vendor-payment-accounts-btn')) {
                    const btn = e.target.closest('.edit-vendor-payment-accounts-btn');
                    const vendorPaymentId = btn.dataset.vendorPaymentId;
                    const row = btn.closest('tr');
                    
                    currentEditVendorPaymentId = vendorPaymentId;
                    document.getElementById('vendorPaymentAccountsId').value = vendorPaymentId;
                    
                    // Populate editable fields
                    document.getElementById('accountsModalPaidAmount').value = row.cells[5].textContent.trim() !== '-' ? row.cells[5].textContent.trim().replace(/[₹,]/g, '') : '';
                    document.getElementById('accountsModalPendingAmount').value = row.cells[6].textContent.trim() !== '-' ? row.cells[6].textContent.trim().replace(/[₹,]/g, '') : '';
                    document.getElementById('accountsModalPaymentMode').value = row.cells[7].textContent.trim() !== '-' ? row.cells[7].textContent.trim() : '';
                    document.getElementById('accountsModalRefNo').value = row.cells[8].textContent.trim() !== '-' ? row.cells[8].textContent.trim() : '';
                    document.getElementById('accountsModalRemarks').value = row.cells[9].textContent.trim() !== '-' ? row.cells[9].textContent.trim() : '';
                    
                    // Populate status from row data
                    document.getElementById('accountsModalStatus').value = row.dataset.status || 'Paid';
                }
            });

            // Handle vendor payment form submission
            const submitVendorPaymentAccountsBtn = document.getElementById('submitVendorPaymentAccountsModal');
            if (submitVendorPaymentAccountsBtn) {
                submitVendorPaymentAccountsBtn.addEventListener('click', function() {
                    const form = document.getElementById('editVendorPaymentAccountsForm');
                    const formData = new FormData(form);
                    const vendorPaymentId = document.getElementById('vendorPaymentAccountsId').value;

                    // Add method spoofing for PUT request
                    formData.append('_method', 'PUT');

                    fetch(`/accounts/${leadId}/vendor-payment/${vendorPaymentId}`, {
                        method: 'POST', // Use POST with _method=PUT for Laravel
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                    .then(response => {
                        // Check if response is JSON
                        const contentType = response.headers.get('content-type');
                        if (contentType && contentType.includes('application/json')) {
                            return response.json().then(data => {
                                if (!response.ok) {
                                    // Handle validation errors
                                    if (data.errors) {
                                        const errorMessages = Object.values(data.errors).flat().join('\n');
                                        throw new Error(errorMessages);
                                    }
                                    throw new Error(data.message || 'Failed to update vendor payment');
                                }
                                return data;
                            });
                        } else {
                            // If not JSON, might be a redirect or error page
                            if (!response.ok) {
                                throw new Error('Failed to update vendor payment');
                            }
                            return { success: true };
                        }
                    })
                    .then(data => {
                        if (data.success) {
                            // Close modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById('editVendorPaymentAccountsModal'));
                            if (modal) {
                                modal.hide();
                            }
                            // Reload page to show updated data
                            window.location.reload();
                        } else {
                            alert(data.message || 'Failed to update vendor payment');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert(error.message || 'An error occurred while updating vendor payment');
                    });
                });
            }

            // Reset modal on close
            const editVendorPaymentAccountsModal = document.getElementById('editVendorPaymentAccountsModal');
            if (editVendorPaymentAccountsModal) {
                editVendorPaymentAccountsModal.addEventListener('hidden.bs.modal', function() {
                    document.getElementById('editVendorPaymentAccountsForm').reset();
                    currentEditVendorPaymentId = null;
                });
            }

            // Customer Payment Accounts handlers
            let currentEditCustomerPaymentId = null;

            // Handle edit customer payment button click
            document.addEventListener('click', function(e) {
                if (e.target.closest('.edit-customer-payment-btn')) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const btn = e.target.closest('.edit-customer-payment-btn');
                    const paymentId = btn.dataset.paymentId;
                    
                    currentEditCustomerPaymentId = paymentId;
                    document.getElementById('customerPaymentAccountsId').value = paymentId;
                    
                    // Populate fields
                    document.getElementById('custModalAmount').value = btn.dataset.amount || '';
                    
                    // Handle method value - convert to proper case if needed
                    let methodValue = btn.dataset.method || 'Cash';
                    // Map lowercase values to capitalized ones
                    const methodMap = {
                        'cash': 'Cash',
                        'bank_transfer': 'Bank Transfer',
                        'cheque': 'Cheque',
                        'card': 'Card',
                        'online': 'Online',
                        'upi': 'UPI',
                        'neft': 'NEFT',
                        'rtgs': 'RTGS',
                        'wib': 'WIB',
                        'other': 'Other'
                    };
                    if (methodMap[methodValue.toLowerCase()]) {
                        methodValue = methodMap[methodValue.toLowerCase()];
                    }
                    document.getElementById('custModalMethod').value = methodValue;
                    
                    document.getElementById('custModalPaymentDate').value = btn.dataset.paymentDate || '';
                    document.getElementById('custModalDueDate').value = btn.dataset.dueDate || '';
                    document.getElementById('custModalReference').value = btn.dataset.reference || '';
                    document.getElementById('custModalStatus').value = btn.dataset.status || 'pending';
                    
                    // Manually open the modal
                    const modalElement = document.getElementById('editCustomerPaymentAccountsModal');
                    if (modalElement) {
                        const modal = new bootstrap.Modal(modalElement);
                        modal.show();
                    }
                }
            });

            // Handle customer payment form submission
            const submitCustomerPaymentBtn = document.getElementById('submitCustomerPaymentAccountsModal');
            if (submitCustomerPaymentBtn) {
                submitCustomerPaymentBtn.addEventListener('click', function() {
                    const form = document.getElementById('editCustomerPaymentAccountsForm');
                    const formData = new FormData(form);
                    const paymentId = document.getElementById('customerPaymentAccountsId').value;
                    const leadId = {{ $lead->id }};

                    const url = `/leads/${leadId}/payments/${paymentId}`;
                    // Method spoofing for PUT
                    formData.append('_method', 'PUT');

                    fetch(url, {
                        method: 'POST', // Using POST with _method=PUT
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Close modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById('editCustomerPaymentAccountsModal'));
                            if (modal) {
                                modal.hide();
                            }
                            // Reload page to show updated data
                            window.location.reload();
                        } else {
                            alert(data.message || 'Failed to update payment');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while updating payment');
                    });
                });
            }

            // Reset modal on close
            const editCustomerPaymentAccountsModal = document.getElementById('editCustomerPaymentAccountsModal');
            if (editCustomerPaymentAccountsModal) {
                editCustomerPaymentAccountsModal.addEventListener('hidden.bs.modal', function() {
                    document.getElementById('editCustomerPaymentAccountsForm').reset();
                    currentEditCustomerPaymentId = null;
                });
            }

        });
    </script>
    @endpush
@endsection

