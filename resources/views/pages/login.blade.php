<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="shortcut icon" href="{{ asset('assets') }}/logo.png" type="icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="flex justify-center items-center min-h-screen px-5">
        <div class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
            <form class="space-y-6" action="#">
                <h5 class="text-xl font-medium text-gray-900 dark:text-white">Sign in to our platform</h5>
                <div>
                    <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                    <input type="text" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#597a6f] focus:border-[#597a6f] block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="shank" required autocomplete="off" />
                </div>
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                    <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#597a6f] focus:border-[#597a6f] block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" onkeypress="enterLogin(event)" required />
                    <small class="text-red-500"></small>
                </div>
                <div class="flex items-start">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" />
                        </div>
                        <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember me</label>
                    </div>
                </div>
                <button
                    type="button"
                    id="login"
                    class="w-full text-white bg-[#597a6f] hover:bg-[#4e6b62] focus:ring-4 focus:outline-none focus:ring-[#89bbab] font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-[#4e6b62] disabled:opacity-60"
                >
                    Login
                </button>
            </form>
            <div class="text-center mt-10">
                <a href="{{ route('panel.login') }}" class="text-xs text-gray-600 p-3 bg-white border border-gray-400 rounded-lg">Login as Administrator</a>
            </div>
        </div>
    </div>
    <script>
        const usernameInput = document.querySelector('input[name="username"]');
        const passwordInput = document.querySelector('input[name="password"]');
        const loginButton = document.getElementById('login');
        const spinnerIcon = '<svg aria-hidden="true" role="status" class="inline w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/></svg>';

        const enterLogin = async (e) => {
            if (e.keyCode === 13) {
                await loginFlow();
            }
        }

        loginButton.addEventListener('click', async () => {
            await loginFlow();
        });

        const loginFlow = async () => {
            clearError();
            disabledElement();

            const response = await login();

            if (response.status === 'success') {
                return window.location.href = `${window.location.origin}/home`;
            }

            if (response.error) {
                showError(response.error);
            }

            enabledElement();
            passwordInput.focus();
        }

        const login = async () => {
            const csrfToken = '{{ csrf_token() }}';
            const body = {
                username: usernameInput.value,
                password: passwordInput.value
            };
            const encodedBody = new URLSearchParams(body);
            const options = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: encodedBody
            }
            const response = await fetch(`${window.location.origin}/login`, options);
            const result = await response.json();
            return result;
        }

        const enabledElement = () => {
            usernameInput.removeAttribute('disabled');
            passwordInput.removeAttribute('disabled');
            loginButton.removeAttribute('disabled');
            loginButton.innerHTML = 'Login';
        }

        const disabledElement = () => {
            usernameInput.setAttribute('disabled', '');
            passwordInput.setAttribute('disabled', '');
            loginButton.setAttribute('disabled', '');
            loginButton.innerHTML = `${spinnerIcon} Loading`;
        }

        const showError = (error) => {
            passwordInput.nextElementSibling.textContent = error;
        }

        const clearError = () => {
            passwordInput.nextElementSibling.textContent = '';
        }
    </script>
</body>
</html>
