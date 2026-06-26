@php
    $variant = $variant ?? 'auth';
    $required = $required ?? true;
    $labelSuffix = $labelSuffix ?? '';
    $wrapperClass = $wrapperClass ?? 'mb-3';
    $wrapClass = $variant === 'auth' ? 'auth-input-wrap auth-password-wrap' : 'reg-password-wrap';
    $inputClass = $variant === 'auth'
        ? 'form-control auth-input auth-password-input'
        : 'form-control reg-input reg-password-input';
@endphp

<div class="{{ $wrapperClass }}">
    <label for="{{ $id }}" class="form-label">{!! $label !!}{!! $labelSuffix !!}</label>
    <div class="{{ $wrapClass }}">
        @if($variant === 'auth')
            <i class="ri-lock-line auth-icon"></i>
        @endif
        <input type="password"
            name="{{ $name }}"
            id="{{ $id }}"
            class="{{ $inputClass }}"
            placeholder="{{ $placeholder ?? '' }}"
            @if($required) required @endif
            autocomplete="{{ $autocomplete ?? ($name === 'password_confirmation' ? 'new-password' : 'current-password') }}">
        <button type="button"
            class="password-toggle-btn"
            data-password-toggle="{{ $id }}"
            aria-label="Show password"
            aria-pressed="false">
            <i class="ri-eye-line password-toggle-icon password-toggle-icon--show" aria-hidden="true"></i>
            <i class="ri-eye-off-line password-toggle-icon password-toggle-icon--hide" aria-hidden="true"></i>
        </button>
    </div>
</div>

@once
@push('styles')
<style>
.auth-password-wrap .auth-password-input,
.reg-password-wrap .reg-password-input {
    padding-right: 46px !important;
}
.auth-password-wrap .password-toggle-btn {
    right: 12px;
}
.reg-password-wrap {
    position: relative;
}
.reg-password-wrap .reg-password-input {
    width: 100%;
}
.reg-password-wrap .password-toggle-btn {
    right: 10px;
}
.password-toggle-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    border: 0;
    background: transparent;
    color: #9c9ac2;
    padding: 4px;
    line-height: 1;
    cursor: pointer;
    z-index: 6;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.password-toggle-btn:hover {
    color: #322f89;
}
.password-toggle-btn:focus {
    outline: none;
    color: #322f89;
}
.password-toggle-icon {
    font-size: 18px;
}
.password-toggle-icon--hide {
    display: none;
}
.password-toggle-btn.is-visible .password-toggle-icon--show {
    display: none;
}
.password-toggle-btn.is-visible .password-toggle-icon--hide {
    display: inline;
}
</style>
@endpush
@push('scripts')
<script>
(function () {
    if (window.__passwordToggleInit) return;
    window.__passwordToggleInit = true;

    document.addEventListener('click', function (e) {
        var btn = e.target.closest('[data-password-toggle]');
        if (!btn) return;

        var input = document.getElementById(btn.getAttribute('data-password-toggle'));
        if (!input) return;

        var show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        btn.classList.toggle('is-visible', show);
        btn.setAttribute('aria-pressed', show ? 'true' : 'false');
        btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
    });
})();
</script>
@endpush
@endonce
