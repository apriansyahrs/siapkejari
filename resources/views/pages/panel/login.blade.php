<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
        <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
        <title>Login</title>
        <link rel="shortcut icon" href="{{ asset('assets') }}/logo.png" type="icon">
        <link href="{{ asset('assets') }}/dist/css/tabler.min.css?1684106062" rel="stylesheet"/>
        <link href="{{ asset('assets') }}/dist/css/tabler-flags.min.css?1684106062" rel="stylesheet"/>
        <link href="{{ asset('assets') }}/dist/css/tabler-payments.min.css?1684106062" rel="stylesheet"/>
        <link href="{{ asset('assets') }}/dist/css/tabler-vendors.min.css?1684106062" rel="stylesheet"/>
        <link href="{{ asset('assets') }}/dist/css/demo.min.css?1684106062" rel="stylesheet"/>
        <style>
        @import url('https://rsms.me/inter/inter.css');
        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }
        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
        </style>
    </head>
    <body  class=" d-flex flex-column">
        <script src="{{ asset('assets') }}/dist/js/demo-theme.min.js?1684106062"></script>
        <div class="page page-center">
            <div class="container container-tight py-4">
                <div class="text-center mb-4">
                    <a href="#" class="navbar-brand navbar-brand-autodark fs-1">
                        SIAPP
                    </a>
                </div>
                <div class="card card-md">
                    <div class="card-body">
                        <h2 class="h2 text-center mb-4">Login to your account</h2>
                        <div class="text-danger text-center mb-3" id="error-message"></div>
                        <form action="./" method="get" autocomplete="off" novalidate>
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" placeholder="Your username" autocomplete="off">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Password</label>
                                <div class="input-group input-group-flat">
                                    <input type="password" class="form-control" name="password" placeholder="Your password" autocomplete="off" onkeypress="enterLogin(event)">
                                    <span class="input-group-text">
                                        <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                        </a>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="form-check">
                                    <input type="checkbox" class="form-check-input" name="remember-me"/>
                                    <span class="form-check-label">Remember me on this device</span>
                                </label>
                            </div>
                            <div class="form-footer">
                                <button type="button" id="login" class="btn btn-primary w-100">Sign in</button>
                            </div>
                            <div class="text-center">
                                <a href="{{ route('login') }}" class="btn border mt-4">Login as Employee</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Libs JS -->
        <!-- Tabler Core -->
        <script src="{{ asset('assets') }}/dist/js/tabler.min.js?1684106062" defer></script>
        <script src="{{ asset('assets') }}/dist/js/demo.min.js?1684106062" defer></script>
        <script>
            const usernameInput = document.querySelector('input[name="username"]');
            const passwordInput = document.querySelector('input[name="password"]');
            const rememberMe = document.querySelector('input[name="remember-me"]');
            const loginButton = document.getElementById('login');
            const spinnerIcon = '<div class="spinner-border spinner-border-sm me-2" role="status"></div>';
            const errorMessageElement = document.getElementById('error-message');

            const enterLogin = async (e) => {
                if (e.keyCode === 13) {
                    await loginFlow();
                }
            }

            loginButton.addEventListener('click', async () => {
                await loginFlow();
            });

            const disabledElement = () => {
                usernameInput.setAttribute('disabled', '');
                passwordInput.setAttribute('disabled', '');
                rememberMe.setAttribute('disabled', '');
                loginButton.setAttribute('disabled', '');
                loginButton.innerHTML = `${spinnerIcon} Loading`;
            };

            const enabledElement = () => {
                usernameInput.removeAttribute('disabled');
                passwordInput.removeAttribute('disabled');
                rememberMe.removeAttribute('disabled');
                loginButton.removeAttribute('disabled');
                loginButton.innerHTML = 'Sign in';
            }

            const showError = (error) => {
                errorMessageElement.textContent = error;
            };

            const clearError = () => {
                errorMessageElement.textContent = '';
            };

            const login = async () => {
                const csrfToken = '{{ csrf_token() }}';
                const body = {
                    username: usernameInput.value,
                    password: passwordInput.value,
                    remember_me: rememberMe.checked
                };
                const encodedBody = new URLSearchParams(body);
                const options = {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: encodedBody,
                };
                const response = await fetch(`${window.location.origin}/panel/login`, options);
                const result = await response.json();
                return result;
            }

            const loginFlow = async () => {
                disabledElement();
                clearError();

                const response = await login()

                if (response.status === 'success') {
                    return window.location.href = `${window.location.origin}/panel/dashboard`;
                }

                if (response.error) {
                    showError(response.error);
                }

                enabledElement();
                passwordInput.focus();
            }
        </script>
    </body>
</html>
