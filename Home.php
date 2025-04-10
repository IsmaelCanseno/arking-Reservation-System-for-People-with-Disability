<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EZIO | Accessible Parking Solutions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        :root {
            --primary: #1e37c4;
            --primary-blue: #2759c5;
            --primary-dark: #013193;
            --primary-light: #e0f0ff;
            --accent: #3771c9;
            --light-blue: #e0f0ff;
            --border-color: #bfdbfe;
            --dark: #1b263b;
            --light: #f8f9fa;
            --card-bg: #ffffff;
            --text: #2b2d42;
            --text-light: #8d99ae;
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            --white: #ffffff;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.12);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 25px rgba(0,0,0,0.1);
            --shadow-xl: 0 20px 50px rgba(0,0,0,0.2);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.6;
            color: var(--text);
            background-color: var(--light);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            height: 100vh;
            position: relative;
            touch-action: manipulation;
        }
        
        #map {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 100%;
            z-index: 1;
        }
        
        /* Custom Map Tiles Style */
        .leaflet-tile {
            filter: hue-rotate(190deg) saturate(1.2) brightness(0.95) contrast(0.9);
        }
        
        .leaflet-container {
            background: #e0f0ff !important;
        }
        
        /* Header Styles */
        .app-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.8rem 1rem;
            background: var(--light);
            color: var(--text);
            position: fixed;
            top: 0;
            width: 100%;
            box-shadow: var(--shadow-sm);
            min-height: 56px;
            z-index: 100;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .logo {
            width: 40px;
            height: 40px;
            border-radius: 30%;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .logo img{
            height: 40px;
        }
        
        .logo:hover {
            transform: scale(1.1);
            box-shadow: var(--shadow-md);
        }
        
        .app-name {
            font-weight: 700;
            font-size: 1.1rem;
            background: linear-gradient(to right, var(--primary), var(--accent));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        /* Bottom Sheet */
        .bottom-sheet {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--white);
            border-radius: 24px 24px 0 0;
            box-shadow: var(--shadow-xl);
            z-index: 100;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateY(calc(100% - 70px));
            height: 70vh;
            max-height: 90vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            touch-action: none;
        }
        
        .bottom-sheet.expanded {
            transform: translateY(0);
        }
        
        .bottom-sheet.closing {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.6, 1);
        }
        
        .sheet-header {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            border-bottom: 1px solid rgba(0,0,0,0.1);
            touch-action: none;
        }

        .drag-handle {
            width: 40px;
            height: 4px;
            background: rgba(0,0,0,0.2);
            border-radius: 2px;
            margin-bottom: 0.5rem;
        }
        
        .sheet-title {
            font-weight: 600;
            font-size: 1rem;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }
        
        .sheet-content {
            flex: 1;
            overflow-y: auto;
            padding: 0 1rem 1rem;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Search Bar */
        .search-container {
            position: relative;
            margin-bottom: 1rem;
        }
        
        .search-input {
            width: 80%;
            padding: 0.8rem 0.2rem 0.8rem 2.8rem;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            font-size: 0.95rem;
            background: var(--light);
            transition: var(--transition);
            appearance: none;
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(39, 89, 197, 0.2);
        }
        
        .search-icon {
            position: flex;
            margin-left: 20px;
            color: var(--light);
            border: var(--primary);
            border-style: solid;
            border-width: 9px;
            border-radius: 40%;
            background: var(--primary)
        }


        
        /* Menu Options */
        .menu-options {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.8rem;
            margin-top: 1rem;
        }
        
        .menu-option {
            background: var(--light);
            border-radius: 12px;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: var(--transition);
            cursor: pointer;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .menu-option:hover {
            background: var(--white);
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }
        
        .option-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }
        
        .option-title {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--dark);
        }
        
        .option-desc {
            font-size: 0.75rem;
            color: var(--text-light);
            margin-top: 0.2rem;
        }
        
        /* Nearby Parking Section */
        .parking-section {
            margin-top: 1.5rem;
        }
        
        .section-title {
            font-weight: 600;
            font-size: 1rem;
            color: var(--dark);
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .view-all {
            font-size: 0.8rem;
            color: var(--primary);
            font-weight: 500;
            text-decoration: none;
        }
        
        .parking-list {
            display: flex;
            gap: 0.8rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
            scrollbar-width: none;
            -webkit-overflow-scrolling: touch;
        }
        
        .parking-list::-webkit-scrollbar {
            display: none;
        }
        
        .parking-card {
            min-width: 220px;
            background: var(--white);
            border-radius: 12px;
            padding: 0.9rem;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            border: 1px solid rgba(0,0,0,0.05);
            flex-shrink: 0;
        }
        
        .parking-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }
        
        .parking-name {
            font-weight: 600;
            margin-bottom: 0.4rem;
            color: var(--dark);
            font-size: 0.95rem;
        }
        
        .parking-location {
            font-size: 0.8rem;
            color: var(--text-light);
            margin-bottom: 0.6rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .parking-distance {
            font-size: 0.75rem;
            color: var(--primary);
            background: var(--light-blue);
            padding: 0.2rem 0.5rem;
            border-radius: 50px;
            margin-top: 0.4rem;
            display: inline-block;
        }
        
        .parking-availability {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 0.8rem;
        }
        
        .availability-label {
            font-size: 0.75rem;
            color: var(--text-light);
        }
        
        .availability-count {
            font-weight: 600;
            color: var(--primary);
            font-size: 0.9rem;
        }
        
        .book-btn {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            color: white;
            border: none;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .book-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }
        
        /* Overlay Menu */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 200;
            display: none;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .overlay.active {
            display: flex;
            opacity: 1;
        }
        
        .overlay.closing {
            opacity: 0;
        }
        
        .overlay-content {
            background: var(--white);
            border-radius: 16px;
            padding: 1.5rem;
            width: calc(100% - 40px);
            max-width: 400px;
            margin: 20px;
            transform: translateY(20px) scale(0.95);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: var(--shadow-xl);
            position: relative;
            overflow: hidden;
            opacity: 0;
        }
        
        .overlay.active .overlay-content {
            transform: translateY(0) scale(1);
            opacity: 1;
        }
        
        .overlay.closing .overlay-content {
            transform: translateY(20px) scale(0.95);
            opacity: 0;
        }
        
        .overlay-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.2rem;
        }
        
        .overlay-title {
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--dark);
        }
        
        .close-btn {
            background: none;
            border: none;
            font-size: 1.3rem;
            color: var(--text-light);
            cursor: pointer;
            padding: 0.5rem;
            margin: -0.5rem;
            transition: transform 0.2s ease;
        }
        
        .close-btn:hover {
            transform: rotate(90deg);
        }
        
        .menu-list {
            list-style: none;
        }

        .menu-list a{
            text-decoration: none;
        }
        
        .menu-item {
            padding: 0.9rem 0;
            border-bottom: 1px solid rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 0.8rem;
            cursor: pointer;
            transition: var(--transition);
            opacity: 0;
            transform: translateX(-10px);
        }
        
        .overlay.active .menu-item {
            opacity: 1;
            transform: translateX(0);
        }
        
        .overlay.active .menu-item:nth-child(1) {
            transition-delay: 0.1s;
        }
        .overlay.active .menu-item:nth-child(2) {
            transition-delay: 0.15s;
        }
        .overlay.active .menu-item:nth-child(3) {
            transition-delay: 0.2s;
        }
        .overlay.active .menu-item:nth-child(4) {
            transition-delay: 0.25s;
        }
        .overlay.active .menu-item:nth-child(5) {
            transition-delay: 0.3s;
        }
        .overlay.active .menu-item:nth-child(6) {
            transition-delay: 0.35s;
        }
        
        .menu-item:last-child {
            border-bottom: none;
        }
        
        .menu-item:hover {
            transform: translateX(5px);
        }
        
        .menu-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1rem;
            flex-shrink: 0;
            transition: var(--transition);
        }
        
        .menu-item:hover .menu-icon {
            background: var(--primary);
            color: white;
            transform: scale(1.1);
        }
        
        .menu-text {
            flex: 1;
        }
        
        .menu-name {
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 0.1rem;
            font-size: 0.95rem;
        }
        
        .menu-desc {
            font-size: 0.75rem;
            color: var(--text-light);
        }
        
        .menu-arrow {
            color: var(--text-light);
            font-size: 0.9rem;
            transition: var(--transition);
        }
        
        .menu-item:hover .menu-arrow {
            color: var(--primary);
            transform: translateX(3px);
        }
        
        /* Current Location Button */
        .current-location {
            position: fixed;
            bottom: calc(70vh + 15px);
            right: 15px;
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: var(--white);
            box-shadow: var(--shadow-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 101;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .current-location:hover {
            transform: scale(1.1);
            box-shadow: var(--shadow-xl);
        }
        
        .current-location i {
            color: var(--primary);
            font-size: 1.1rem;
        }

        /* Parking Details Overlay Styles */
        .parking-details-content {
            padding: 0 0.5rem;
        }

        .parking-address {
            color: var(--text-light);
            font-size: 0.85rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .parking-address i {
            font-size: 0.8rem;
        }

        .parking-rules-section {
            margin: 1rem 0;
        }

        .parking-rules-section h4 {
            font-size: 0.95rem;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .parking-rules-text {
            font-size: 0.85rem;
            color: var(--text);
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        .parking-rates {
            margin-top: 1.5rem;
        }

        .parking-rates h4 {
            font-size: 0.95rem;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .rates-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        .rates-table tr:not(:last-child) {
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .rates-table td {
            padding: 0.5rem 0;
        }

        .rates-table td:last-child {
            font-weight: 600;
            text-align: right;
            color: var(--primary);
        }

        .parking-actions {
            display: flex;
            gap: 0.8rem;
            margin-top: 1.5rem;
        }

        .parking-action-btn {
            flex: 1;
            padding: 0.8rem;
            border-radius: 8px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: var(--transition);
        }

        .accept-btn {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            color: white;
        }

        .decline-btn {
            background: var(--light);
            color: var(--text-light);
            border: 1px solid var(--border-color);
        }

        .decline-btn:hover {
            background: #ffebee;
            color: #c62828;
            border-color: #ef9a9a;
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes scaleIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        
        @keyframes slideInFromLeft {
            from { transform: translateX(-20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes slideUp {
            from {
                transform: translateX(-50%) translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateX(-50%) translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideDown {
            from {
                transform: translateX(-50%) translateY(0);
                opacity: 1;
            }
            to {
                transform: translateX(-50%) translateY(20px);
                opacity: 0;
            }
       
        }

        /* Responsive Styles */
        @media (max-width: 480px) {
            .bottom-sheet {
                transform: translateY(calc(100% - 60px));
                height: 65vh;
            }
            
            .current-location {
                bottom: calc(65vh + 15px);
            }
            
            .menu-options {
                grid-template-columns: 1fr;
            }
            
            .app-name {
                display: none;
            }
            
            .overlay-content {
                padding: 1.2rem;
            }
            
            .menu-item {
                padding: 0.8rem 0;
            }
        }
    </style>
</head>
<body>
    <!-- Add this PHP code at the very top of your HTML file -->
    <?php
    session_start();
    include 'connect.php';
    
    if(!isset($_SESSION['uname'])) {
        header("Location: index.php");
        exit();
    }
    
    $email = $_SESSION['uname'];
    $userQuery = "SELECT * FROM users WHERE uname = '$uname'";
    $userResult = $conn->query($userQuery);
    
    if($userResult->num_rows > 0) {
        $user = $userResult->fetch_assoc();
    } else {
        // Handle case where user doesn't exist
        session_destroy();
        header("Location: index.php");
        exit();
    }
    ?>

    <!-- Map Container -->
    <div id="map"></div>
    
    <!-- Header -->
    <header class="app-header">
        <div class="logo-container">
            <div class="logo" id="menuButton">
                <img src="Logo.png" alt="Logo">
            </div>
            <div class="app-name">EZIO</div>
        </div>
    </header>
    
    <!-- Current Location Button -->
    <div class="current-location" id="currentLocation">
        <i class="fas fa-location-arrow"></i>
    </div>
    
    <!-- Bottom Sheet -->
    <div class="bottom-sheet" id="bottomSheet">
        <div class="sheet-header" id="sheetHandle">
            <div class="drag-handle"></div>
            <div class="sheet-title">Search for parking</div>
        </div>
        
        <div class="sheet-content">
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Search for accessible parking...">
                <a href="Home2.html">
                    <i class="fas fa-search search-icon"></i>
                </a>
            </div>
            
            
            <div class="menu-options">
                
                
                <div class="menu-option">
                    <div class="option-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="option-title">Reservations</div>
                    <div class="option-desc">Book in advance</div>
                </div>
                
                <div class="menu-option">
                    <div class="option-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="option-title">Favorites</div>
                    <div class="option-desc">Saved locations</div>
                </div>
            </div>
            
            
        </div>
    </div>
    
    <!-- Overlay Menu -->
    <div class="overlay" id="overlayMenu">
        <div class="overlay-content">
            <div class="overlay-header">
                <div class="overlay-title">Menu</div>
                <button class="close-btn" id="closeMenu">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <ul class="menu-list">
            <a href="Profile.html">
                    <li class="menu-item">
                        <div class="menu-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="menu-text">
                        <div class="menu-name"><?php echo htmlspecialchars($user['fname']) . ' ' . htmlspecialchars($user['lname']); ?></div>
                            <div class="menu-desc">View and edit your profile</div>
                        </div>
                        <i class="fas fa-chevron-right menu-arrow"></i>
                    </li>
                </a>
                
                <a href="Identification-&-Verification.html">
                    <li class="menu-item">
                        <div class="menu-icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <div class="menu-text">
                            <div class="menu-name">Verification</div>
                            <div class="menu-desc">Manage disability verification</div>
                        </div>
                        <i class="fas fa-chevron-right menu-arrow"></i>
                    </li>
                </a>
                
                <a href="Settings.html">
                    <li class="menu-item">
                        <div class="menu-icon">
                            <i class="fas fa-cog"></i>
                        </div>
                        <div class="menu-text">
                            <div class="menu-name">Settings</div>
                            <div class="menu-desc">App preferences</div>
                        </div>
                        <i class="fas fa-chevron-right menu-arrow"></i>
                    </li>
                </a>
                
                <a href="Help-&-Support.html">
                    <li class="menu-item">
                        <div class="menu-icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <div class="menu-text">
                            <div class="menu-name">Help & Support</div>
                            <div class="menu-desc">FAQs and contact</div>
                        </div>
                        <i class="fas fa-chevron-right menu-arrow"></i>
                    </li>
                </a>
                
                <a href="Privacy.html">
                    <li class="menu-item">
                        <div class="menu-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="menu-text">
                            <div class="menu-name">Privacy Policy</div>
                            <div class="menu-desc">How we protect your data</div>
                        </div>
                        <i class="fas fa-chevron-right menu-arrow"></i>
                    </li>
                </a>
                
                <a href="Log-In.html">
                    <li class="menu-item">
                        <div class="menu-icon">
                            <i class="fas fa-sign-out-alt"></i>
                        </div>
                        <div class="menu-text">
                            <div class="menu-name">Logout</div>
                            <div class="menu-desc">Sign out of your account</div>
                        </div>
                        <i class="fas fa-chevron-right menu-arrow"></i>
                    </li>
                </a>
            </ul>
        </div>
    </div>

    <!-- Parking Details Overlay -->
    <div class="overlay" id="parkingDetailsOverlay">
        <div class="overlay-content" style="max-width: 350px;">
            <div class="overlay-header">
                <div class="overlay-title" id="parkingLocationName">Location Name</div>
                <button class="close-btn" id="closeParkingDetails">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="parking-details-content">
                <div class="parking-address" id="parkingLocationAddress">
                    <i class="fas fa-map-marker-alt"></i> Taft Ave N, Pasay
                </div>
                
                <div class="parking-rules-section">
                    <h4>Parking Rules and Conditions</h4>
                    <p class="parking-rules-text">
                        This establishment is not responsible for theft or damage of cars or contents however caused.
                        Car left at car owner's risk.
                    </p>
                    
                    <div class="parking-rates">
                        <h4>Rating System</h4>
                        <table class="rates-table">
                            <tr>
                                <td>First 3 hours</td>
                                <td>P50.00</td>
                            </tr>
                            <tr>
                                <td>Exceeding hours</td>
                                <td>P10.00</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="parking-actions">
                    <button class="parking-action-btn decline-btn" id="declineParking">Cancel</button>
                    <button class="parking-action-btn accept-btn" id="acceptParking">Accept</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Leaflet JS for Maps -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Default coordinates for Arellano University Jose Abad Santos Campus in Pasay
        const defaultCoords = [14.5531, 120.99799303967];
        
        // Initialize Map
        const map = L.map('map').setView(defaultCoords, 20); // Zoom level 16 for close-up
        
        // Add Tile Layer with blue/white color scheme
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        // Add marker for Arellano University
        
        // Add some sample markers for accessible parking
        const parkingSpots = [
            
        ];
        
        // Custom accessible parking icon
        const accessibleIcon = L.divIcon({
            html: '<i class="fas fa-wheelchair" style="color: #1e37c4; font-size: 24px; background: white; border-radius: 50%; padding: 8px;"></i>',
            className: 'leaflet-accessible-icon',
            iconSize: [40, 40],
            iconAnchor: [20, 40]
        });
        
        // Add markers to map
        parkingSpots.forEach(spot => {
            const marker = L.marker(spot.coords, { icon: accessibleIcon }).addTo(map);
            marker.bindPopup(`
                <b>${spot.name}</b><br>
                Available: ${spot.available}/${spot.total} spots<br>
                Distance: ${spot.distance}
            `);
            
            marker.on('click', function() {
                showParkingDetails(spot.name, spot.address);
            });
        });

        // Parking Details Overlay Functionality
        const parkingDetailsOverlay = document.getElementById('parkingDetailsOverlay');
        const closeParkingDetails = document.getElementById('closeParkingDetails');
        const declineParkingBtn = document.getElementById('declineParking');
        const acceptParkingBtn = document.getElementById('acceptParking');

        // Function to show parking details
        function showParkingDetails(name, address) {
            document.getElementById('parkingLocationName').textContent = name;
            document.getElementById('parkingLocationAddress').innerHTML = `<i class="fas fa-map-marker-alt"></i> ${address}`;
            parkingDetailsOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        // Close parking details
        closeParkingDetails.addEventListener('click', function() {
            parkingDetailsOverlay.classList.add('closing');
            
            setTimeout(() => {
                parkingDetailsOverlay.classList.remove('active', 'closing');
                document.body.style.overflow = '';
            }, 300);
        });

        // Decline parking
        declineParkingBtn.addEventListener('click', function() {
            parkingDetailsOverlay.classList.add('closing');
            
            setTimeout(() => {
                parkingDetailsOverlay.classList.remove('active', 'closing');
                document.body.style.overflow = '';
            }, 300);
        });

        // Accept parking
        acceptParkingBtn.addEventListener('click', function() {
            // Here you would handle the booking logic
            alert('Parking spot booked successfully!');
            parkingDetailsOverlay.classList.add('closing');
            
            setTimeout(() => {
                parkingDetailsOverlay.classList.remove('active', 'closing');
                document.body.style.overflow = '';
            }, 300);
        });

        // Close overlay when clicking outside content
        parkingDetailsOverlay.addEventListener('click', function(e) {
            if (e.target === parkingDetailsOverlay) {
                parkingDetailsOverlay.classList.add('closing');
                
                setTimeout(() => {
                    parkingDetailsOverlay.classList.remove('active', 'closing');
                    document.body.style.overflow = '';
                }, 300);
            }
        });

        // Modify your existing parking card click handlers to show the details overlay
        document.querySelectorAll('.parking-card').forEach(card => {
            card.addEventListener('click', function() {
                const name = this.querySelector('.parking-name').textContent;
                const address = this.querySelector('.parking-location').textContent.replace('away', '').trim();
                showParkingDetails(name, address);
            });
        });

        // Also modify your existing book buttons to show the details overlay
        document.querySelectorAll('.book-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const card = this.closest('.parking-card');
                const name = card.querySelector('.parking-name').textContent;
                const address = card.querySelector('.parking-location').textContent.replace('away', '').trim();
                showParkingDetails(name, address);
            });
        });
        
        // Bottom Sheet Functionality
        const bottomSheet = document.getElementById('bottomSheet');
        const sheetHandle = document.getElementById('sheetHandle');
        let startY, startHeight, isDragging = false;
        
        sheetHandle.addEventListener('mousedown', startDrag);
        sheetHandle.addEventListener('touchstart', startDrag, { passive: false });
        
        function startDrag(e) {
            e.preventDefault();
            isDragging = true;
            startY = e.type === 'mousedown' ? e.clientY : e.touches[0].clientY;
            startHeight = parseInt(document.defaultView.getComputedStyle(bottomSheet).height, 10);
            
            document.addEventListener('mousemove', onDrag);
            document.addEventListener('touchmove', onDrag, { passive: false });
            document.addEventListener('mouseup', stopDrag);
            document.addEventListener('touchend', stopDrag);
        }
        
        function onDrag(e) {
            if (!isDragging) return;
            e.preventDefault();
            const y = e.type === 'mousemove' ? e.clientY : e.touches[0].clientY;
            const deltaY = startY - y;
            const newHeight = startHeight + deltaY;
            
            // Limit the height between 70px and 70vh
            if (newHeight > 70 && newHeight < window.innerHeight * 0.7) {
                bottomSheet.style.height = `${newHeight}px`;
            }
        }
        
        function stopDrag() {
            if (!isDragging) return;
            isDragging = false;
            
            document.removeEventListener('mousemove', onDrag);
            document.removeEventListener('touchmove', onDrag);
            document.removeEventListener('mouseup', stopDrag);
            document.removeEventListener('touchend', stopDrag);
            
            // Snap to expanded or collapsed state
            const currentHeight = parseInt(document.defaultView.getComputedStyle(bottomSheet).height, 10);
            const threshold = window.innerHeight * 0.4;
            
            if (currentHeight > threshold) {
                expandSheet();
            } else {
                collapseSheet();
            }
        }
        
        function expandSheet() {
            bottomSheet.classList.remove('closing');
            bottomSheet.style.height = '70vh';
            bottomSheet.classList.add('expanded');
        }
        
        function collapseSheet() {
            bottomSheet.classList.add('closing');
            bottomSheet.style.height = '70px';
            bottomSheet.classList.remove('expanded');
            
            // Remove closing class after animation
            setTimeout(() => {
                bottomSheet.classList.remove('closing');
            }, 300);
        }
        
        // Toggle bottom sheet on header click
        sheetHandle.addEventListener('click', function(e) {
            if (isDragging) return;
            if (e.target === sheetHandle || e.target.classList.contains('sheet-title') || e.target.classList.contains('drag-handle')) {
                if (bottomSheet.classList.contains('expanded')) {
                    collapseSheet();
                } else {
                    expandSheet();
                }
            }
        });
        
        // Menu Button Functionality
        const menuButton = document.getElementById('menuButton');
        const overlayMenu = document.getElementById('overlayMenu');
        const closeMenu = document.getElementById('closeMenu');
        
        menuButton.addEventListener('click', function() {
            overlayMenu.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
        
        closeMenu.addEventListener('click', function() {
            overlayMenu.classList.add('closing');
            
            setTimeout(() => {
                overlayMenu.classList.remove('active', 'closing');
                document.body.style.overflow = '';
            }, 300);
        });
        
        // Close overlay when clicking outside content
        overlayMenu.addEventListener('click', function(e) {
            if (e.target === overlayMenu) {
                overlayMenu.classList.add('closing');
                
                setTimeout(() => {
                    overlayMenu.classList.remove('active', 'closing');
                    document.body.style.overflow = '';
                }, 300);
            }
        });
        
        // Current Location Button
        const currentLocationBtn = document.getElementById('currentLocation');
        
        currentLocationBtn.addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    position => {
                        map.setView([position.coords.latitude, position.coords.longitude], 16);
                        
                        // Add user location marker
                        L.marker([position.coords.latitude, position.coords.longitude], {
                            icon: L.divIcon({
                                html: '<i class="fas fa-circle" style="color: #3771c9; font-size: 16px;"></i>',
                                className: 'leaflet-user-icon',
                                iconSize: [16, 16],
                                iconAnchor: [8, 8]
                            })
                        }).addTo(map).bindPopup('Your location');
                    },
                    error => {
                        console.log('Unable to get your location: ' + error.message);
                        // Fallback to default location if geolocation fails
                        map.setView(defaultCoords, 16);
                    }
                );
            } else {
                alert('Geolocation is not supported by your browser');
                // Fallback to default location
                map.setView(defaultCoords, 16);
            }
        });
        
        // Try to get user's location on page load
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                position => {
                    map.setView([position.coords.latitude, position.coords.longitude], 16);
                    
                    // Add user location marker
                    L.marker([position.coords.latitude, position.coords.longitude], {
                        icon: L.divIcon({
                            html: '<i class="fas fa-circle" style="color: #3771c9; font-size: 16px;"></i>',
                            className: 'leaflet-user-icon',
                            iconSize: [16, 16],
                            iconAnchor: [8, 8]
                        })
                    }).addTo(map).bindPopup('Your location');
                },
                error => {
                    console.log('Unable to get your location: ' + error.message);
                    // Use default location if geolocation fails
                    map.setView(defaultCoords, 16);
                }
            );
        } else {
            // Use default location if geolocation not supported
            map.setView(defaultCoords, 16);
        }
    </script>
</body>
</html>