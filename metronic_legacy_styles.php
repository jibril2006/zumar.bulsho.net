<?php

function km_metronic_legacy_styles()
{
    return <<<'CSS'
<style>
.row { display: flex; flex-wrap: wrap; margin: -0.5rem; }
.row > [class*="col-"] { padding: 0.5rem; box-sizing: border-box; }
.col-12 { width: 100%; }
.col-sm-6, .col-md-6, .col-lg-6 { width: 100%; }
.col-sm-4, .col-md-4, .col-lg-4 { width: 100%; }
.col-sm-3, .col-md-3, .col-lg-3 { width: 100%; }
.col-md-2, .col-lg-2 { width: 100%; }
.col-md-8, .col-lg-8 { width: 100%; }
.col-lg-12 { width: 100%; }
@media (min-width: 640px) {
    .col-sm-6 { width: 50%; }
    .col-sm-4 { width: 33.3333%; }
    .col-sm-3 { width: 25%; }
}
@media (min-width: 768px) {
    .col-md-6 { width: 50%; }
    .col-md-4 { width: 33.3333%; }
    .col-md-3 { width: 25%; }
    .col-md-8 { width: 66.6667%; }
    .col-md-2 { width: 16.6667%; }
}
@media (min-width: 992px) {
    .col-lg-6 { width: 50%; }
    .col-lg-4 { width: 33.3333%; }
    .col-lg-3 { width: 25%; }
    .col-lg-12 { width: 100%; }
    .col-lg-2 { width: 16.6667%; }
    .col-lg-8 { width: 66.6667%; }
}

.d-flex, .flex { display: flex; }
.flex-wrap { flex-wrap: wrap; }
.align-items-center { align-items: center; }
.justify-content-between { justify-content: space-between; }
.justify-content-end { justify-content: flex-end; }
.gap-2 { gap: 0.5rem; }
.mb-0 { margin-bottom: 0; }
.mb-2 { margin-bottom: 0.5rem; }
.mb-3 { margin-bottom: 0.75rem; }
.mb-4 { margin-bottom: 1rem; }
.mt-2 { margin-top: 0.5rem; }
.mt-3 { margin-top: 0.75rem; }
.w-100 { width: 100%; }
.text-center { text-align: center; }
.text-end { text-align: right; }
.text-muted { color: #64748b; }
.pull-right { float: right; }

.btn:not(.btn-xs), .btn.green:not(.btn-xs), .btn.btn-success:not(.btn-xs), .btn.btn-primary:not(.btn-xs) {
    display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem;
    padding: 0.55rem 1rem; border-radius: 0.5rem; border: 1px solid transparent;
    font-weight: 500; font-size: 1rem; text-decoration: none; cursor: pointer;
}
.btn.btn-xs {
    display: inline-flex; align-items: center; justify-content: center; gap: 0.15rem;
    padding: 3px 8px; border-radius: 3px; border: 1px solid transparent;
    font-weight: 600; font-size: 11px; line-height: 1.2; text-decoration: none;
}
.btn.btn-xs.green { background: #0f766e !important; border-color: #115e59 !important; color: #fff !important; }
.btn.btn-xs.grey { background: #e9ecef !important; border-color: #ced4da !important; color: #495057 !important; }
.btn.btn-xs.red { background: #dc3545 !important; border-color: #c82333 !important; color: #fff !important; }
.btn-sm { padding: 0.45rem 0.75rem; font-size: 0.9375rem; }

.form-control, .form-select, select.form-control, textarea.form-control {
    width: 100%; border: 1px solid #e2e8f0; border-radius: 0.5rem;
    padding: 0.6rem 0.85rem; background: #fff; color: #334155; box-sizing: border-box;
    font-size: 1rem;
}
.form-control:focus, select.form-control:focus, textarea.form-control:focus {
    outline: none; border-color: #0f766e; box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.15);
}
.form-group { margin-bottom: 1rem; }
.form-group label, .control-label {
    display: block; font-weight: 600; font-size: 1rem; margin-bottom: 0.35rem; color: #475569;
}

.km-filter-bar {
    display: flex; flex-wrap: wrap; align-items: center; gap: 0.5rem 0.75rem;
    padding: 0.75rem 1rem; margin: 0; background: #f8fafc; border-bottom: 1px solid #e2e8f0;
}
.km-filter-bar label { margin: 0; font-size: 1rem; font-weight: 600; color: #475569; white-space: nowrap; }
.km-filter-bar .km-filter-select {
    width: auto; min-width: 5rem; max-width: 8rem; height: 36px; padding: 0.35rem 0.55rem; font-size: 1rem !important;
}
.km-list-page .km-list-body { padding: 0 !important; }
.km-list-page .km-table-shell { padding: 0; }

.badge, .label { display: inline-flex; align-items: center; padding: 0.2rem 0.55rem; border-radius: 999px; font-size: 0.875rem; font-weight: 600; }
.badge-success, .label-success { background: rgba(15, 118, 110, 0.15); color: #0f766e; }
.badge-danger, .label-danger { background: rgba(220, 53, 69, 0.15); color: #dc3545; }
.badge-primary, .label-primary { background: rgba(15, 118, 110, 0.15); color: #0f766e; }

.alert { padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid #e2e8f0; margin-bottom: 1rem; }
.alert-danger { background: rgba(220, 53, 69, 0.1); color: #dc3545; border-color: rgba(220, 53, 69, 0.35); }
.alert-success { background: rgba(15, 118, 110, 0.1); color: #0f766e; border-color: rgba(15, 118, 110, 0.35); }
.alert-warning { background: rgba(245, 158, 11, 0.12); color: #b45309; border-color: rgba(245, 158, 11, 0.35); }

.dashboard-stat2, .dashboard-stat2.bordered {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 0.75rem;
    padding: 1rem 1.25rem; margin-bottom: 1rem; box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
}
.dashboard-stat { border-radius: 8px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08); }

.modal-content { border-radius: 0.75rem; border: 1px solid #e2e8f0; box-shadow: 0 20px 50px rgba(15, 23, 42, 0.15); }
.modal-header, .modal-footer { border-color: #e2e8f0; }
</style>
CSS;
}
