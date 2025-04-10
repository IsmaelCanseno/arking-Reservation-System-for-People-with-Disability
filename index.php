<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Light mode variables */
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --bg-light: #f9fafb;
            --bg-white: #ffffff;
            --border-color: #e5e7eb;
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --radius-md: 0.5rem;
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            --body-bg: linear-gradient(135deg, #f5f7fa 0%, #8db0e8 100%);
            --outer-container-bg: rgba(255, 255, 255, 0.2);
            --outer-container-border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Dark mode variables */
        [data-theme="dark"] {
            --primary-color: #3b82f6;
            --primary-dark: #2563eb;
            --text-primary: #f3f4f6;
            --text-secondary: #9ca3af;
            --bg-light: #111827;
            --bg-white: #1f2937;
            --border-color: #374151;
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2);
            --body-bg: linear-gradient(135deg, #111827 0%, #1e3a8a 100%);
            --outer-container-bg: rgba(31, 41, 55, 0.3);
            --outer-container-border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo-container {
            text-align: center;
            position: relative;
        }

        .logo img {
            height: 60px;
        }

        .theme-toggle {
            position: absolute;
            top: 0;
            right: 0;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-primary);
            font-size: 1.25rem;
            padding: 0.5rem;
            border-radius: 50%;
            transition: var(--transition);
        }

        .theme-toggle:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        [data-theme="dark"] .theme-toggle:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: var(--bg-light);
            background-image: var(--body-bg);
            transition: background-color 0.5s ease, background-image 0.5s ease;
        }

        .login-outer-container {
            background-color: var(--outer-container-bg);
            backdrop-filter: blur(10px);
            border-radius: var(--radius-md);
            padding: 2rem;
            box-shadow: var(--shadow-md);
            border: var(--outer-container-border);
            width: 100%;
            max-width: 450px;
            animation: fadeIn 0.8s ease-out forwards;
            opacity: 0;
            transition: background-color 0.5s ease, box-shadow 0.5s ease, border 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-container {
            width: 100%;
        }

        .login-box {
            background-color: var(--bg-white);
            border-radius: var(--radius-md);
            padding: 2rem;
            box-shadow: var(--shadow-md);
            transition: background-color 0.5s ease, box-shadow 0.5s ease;
        }

        .login-box h2 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 1.75rem;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        label {
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
            transition: color 0.3s ease;
        }

        input {
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            font-size: 1rem;
            transition: var(--transition);
            background-color: var(--bg-white);
            color: var(--text-primary);
        }

        input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .forgot-password {
            text-align: right;
            margin: -0.5rem 0 0.5rem 0;
        }

        .forgot-password a {
            color: var(--text-secondary);
            font-size: 0.875rem;
            text-decoration: none;
            transition: var(--transition);
        }

        .forgot-password a:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }

        button {
            padding: 0.75rem;
            border-radius: var(--radius-md);
            font-weight: 500;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            border: none;
        }

        button[type="submit"] {
            background-color: var(--primary-color);
            color: white;
            margin-top: 0.5rem;
        }

        button[type="submit"]:hover {
            background-color: var(--primary-dark);
        }

        .register-button {
            width: 100%;
            background-color: transparent;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
            margin-top: 1rem;
        }

        .register-button:hover {
            background-color: rgba(37, 99, 235, 0.1);
        }

        .terms {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.75rem;
            color: var(--text-secondary);
            line-height: 1.4;
            transition: color 0.3s ease;
        }

        .button-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="login-outer-container">
        <div class="login-container">
            <div class="login-box">
                <div class="logo-container">
                    <div class="logo">
                        <img src="Logo.png" alt="Logo">
                    </div>
                    <button class="theme-toggle" id="theme-toggle">
                        <i class="fas fa-moon"></i>
                    </button>
                </div>

                <h2>Log In</h2>
                <form id="login-form" method="post" action="reg.php">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" required>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>

                    <div class="forgot-password">
                        <a href="#">Forgot password?</a>
                    </div>
                    <div class="button-container">
                        <button type="submit" value="Sign In" name="signIn">LOGIN</button>
                    </div>
                    
                </form>

                <div class="button-container">
                    <button id="register-button" class="register-button">REGISTER</button>
                </div>

                <div class="terms">
                    By continuing you agree to PSPD's <br>
                    Terms of Service and Privacy Policy
                </div>
            </div>
        </div>
    </div>

    <script>
        // Theme toggle functionality
        const themeToggle = document.getElementById('theme-toggle');
        const htmlElement = document.documentElement;
        
        // Check for saved theme preference or system preference
        function initializeTheme() {
            const savedTheme = localStorage.getItem('theme');
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            if (savedTheme) {
                htmlElement.setAttribute('data-theme', savedTheme);
                updateThemeIcon(savedTheme);
            } else if (systemPrefersDark) {
                htmlElement.setAttribute('data-theme', 'dark');
                updateThemeIcon('dark');
            } else {
                htmlElement.setAttribute('data-theme', 'light');
                updateThemeIcon('light');
            }
        }
        
        // Update the theme icon based on current theme
        function updateThemeIcon(theme) {
            const icon = themeToggle.querySelector('i');
            if (theme === 'dark') {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }
        }
        
        // Toggle between light and dark mode
        function toggleTheme() {
            const currentTheme = htmlElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            htmlElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        }
        
        // Initialize theme on load
        initializeTheme();
        
        // Set up event listener for theme toggle
        themeToggle.addEventListener('click', toggleTheme);
        
        // Listen for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (!localStorage.getItem('theme')) { // Only change if no manual preference set
                const newTheme = e.matches ? 'dark' : 'light';
                htmlElement.setAttribute('data-theme', newTheme);
                updateThemeIcon(newTheme);
            }
        });

        // Form submission handler
       

        // Register button handler
        document.getElementById("register-button").addEventListener("click", function() {
            // Add fade out animation before redirect
            document.querySelector('.login-outer-container').style.animation = 'fadeOut 0.5s ease-out forwards';
            setTimeout(() => {
                window.location.href = "Register.php";
            }, 500);
        });

        // Add fade out animation
        const style = document.createElement('style');
        style.innerHTML = `
            @keyframes fadeOut {
                from {
                    opacity: 1;
                    transform: translateY(0);
                }
                to {
                    opacity: 0;
                    transform: translateY(20px);
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>