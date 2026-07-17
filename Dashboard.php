<?php
// ==========================================
// RESISYNC RESIDENT ARCHITECTURE (MOCK DATA)
// ==========================================


// 1. 定义用户拥有的角色数组 (您可以修改此数组来测试单角色或多角色场景)
//$userAvailableRoles = ['resident']; 
$userAvailableRoles = ['resident'];

// 2. 自动判断角色数量是否大于 1
$hasMultipleRoles = count($userAvailableRoles) > 1;

// 3. 计算首屏加载的初始激活角色与样式属性
$activeRole = isset($userAvailableRoles[0]) ? $userAvailableRoles[0] : 'resident';

$activeRoleLabel = 'Resident';
$activeRoleClass = 'mode-user';
$activeTriggerSkin = 'trigger-skin-user';
$sidebarRoleBadgeClass = 'badge-user';

if ($activeRole === 'admin') {
    $activeRoleLabel = 'Admin';
    $activeRoleClass = 'mode-admin';
    $activeTriggerSkin = 'trigger-skin-admin';
    $sidebarRoleBadgeClass = 'badge-admin';
} elseif ($activeRole === 'property') {
    $activeRoleLabel = 'Property';
    $activeRoleClass = 'mode-property';
    $activeTriggerSkin = 'trigger-skin-property';
    $sidebarRoleBadgeClass = 'badge-property';
}

$residentStats = [
    'maintenance_status' => 'Paid',
    'active_bookings'    => 2,
    'incoming_parcels'   => 1,
    'community_points'   => 1420
];

$visitorLogs = [
    [
        'name' => 'Sarah Connor',
        'plate' => 'WQA 8821',
        'type' => 'Contractor',
        'check_in' => '10:14 AM',
        'status' => 'Checked In',
        'overstay' => false
    ],
    [
        'name' => 'Marcus Wright',
        'plate' => 'VGD 449',
        'type' => 'Visitor',
        'check_in' => '07:30 AM',
        'status' => 'Overstay Alert',
        'overstay' => true 
    ]
];

$activeBookings = [
    [
        'resource' => 'BBQ Pit 2 (Sunset Zone)',
        'time' => 'Tomorrow, 6:00 PM',
        'type' => 'Space'
    ],
    [
        'resource' => 'Heavy-Duty Power Drill (Bosch)',
        'time' => 'Due in 2 hours',
        'type' => 'Asset'
    ]
];

$defectTickets = [
    [
        'id' => 'TK-902',
        'title' => 'Corridor Light Flickering',
        'location' => 'Block C, Level 4',
        'state' => 'Assigned', 
        'urgency' => 'Low'
    ],
    [
        'id' => 'TK-899',
        'title' => 'Water Pipe Leakage',
        'location' => 'Basement 1, Zone C',
        'state' => 'Pending',
        'urgency' => 'High'
    ]
];

$bulletinBoard = [
    [
        'tag' => 'Events',
        'title' => 'Weekend Eco-Bazaar',
        'content' => 'Join us at the central park area for local foods, sustainable goods, and recycling rewards.',
        'date' => 'This Sat, 9 AM'
    ],
    [
        'tag' => 'Community',
        'title' => 'Lost Cat: Orange Tabby near Block A',
        'content' => 'Responds to "Milo". Please contact Unit A-18-02 if spotted.',
        'date' => 'Yesterday'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ResiSync - Resident Portal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bamboo-stalk: #4A8B5B;
            --bamboo-dark: #1E3524;
            --bamboo-charcoal: #2C3E35;
            --bamboo-shoot: #F4F7F5;
            --warm-earth: #E28743;
            --pure-white: #FFFFFF;
            --card-radius: 20px;
            --transition-smooth: all 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bamboo-shoot);
            color: var(--bamboo-dark);
            height: 100vh;
            overflow: hidden;
            display: flex;
        }

        /* HIDE ALL SCROLLBARS GLOBALLY */
        ::-webkit-scrollbar {
            display: none !important;
        }
        * {
            -ms-overflow-style: none !important;
            scrollbar-width: none !important;
        }

        .portal-container {
            display: flex;
            width: 100%;
            height: 100vh;
            position: relative;
        }

        aside.navigation-panel {
            background-color: var(--bamboo-dark);
            color: var(--pure-white);
            padding: 2.5rem 1.8rem;
            width: 290px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            z-index: 100;
            transition: var(--transition-smooth);
            box-shadow: 10px 0 40px rgba(30, 53, 36, 0.06);
        }

        .portal-container.sidebar-hidden aside.navigation-panel {
            transform: translateX(-100%);
        }

        .brand-section {
            text-align: center;
            margin-bottom: 1rem;
        }

        .brand-section h1 {
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .brand-section span {
            color: var(--bamboo-stalk);
        }

        /* CENTERED PROFILE */
        .user-anchor {
            margin: 1.5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding-bottom: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 100%;
        }

        .user-anchor img {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            border: 3.5px solid var(--bamboo-stalk);
            background: var(--bamboo-charcoal);
            object-fit: cover;
            margin-bottom: 14px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .user-details h4 {
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: -0.2px;
            color: var(--pure-white);
        }

        /* ROLE BADGES FOR SIDEBAR PROFILE */
        .user-details .role-indicator-container {
            margin-top: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.5);
        }

        .sidebar-role-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 30px;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: var(--transition-smooth);
        }

        .badge-user { background-color: rgba(74, 139, 91, 0.2); color: #A4F4B9; }
        .badge-admin { background-color: rgba(217, 78, 78, 0.2); color: #FFA6A6; }
        .badge-property { background-color: rgba(59, 113, 151, 0.2); color: #A9D5F8; }

        nav.menu-links {
            margin-top: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            border-radius: 14px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: var(--transition-smooth);
        }

        .menu-item:hover, .menu-item.active {
            color: var(--pure-white);
            background-color: rgba(255, 255, 255, 0.06);
        }

        .menu-item.active {
            background-color: var(--bamboo-stalk);
            box-shadow: 0 8px 20px rgba(74, 139, 91, 0.25);
        }

        /* LOGOUT BUTTON FIXED AT BOTTOM OF SIDEBAR */
        .logout-btn {
            margin-top: auto;
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            color: rgba(255, 255, 255, 0.5);
            background: transparent;
            border: 1px solid transparent;
            border-radius: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: var(--transition-smooth);
            width: 100%;
            text-align: left;
            user-select: none;
        }

        .logout-btn:hover {
            color: #FF6B6B;
            background-color: rgba(217, 78, 78, 0.1);
            border-color: rgba(217, 78, 78, 0.15);
        }

        main.dashboard-view {
            flex: 1;
            margin-left: 290px;
            height: 100vh;
            overflow-y: auto;
            padding: 2.5rem 3rem;
            transition: var(--transition-smooth);
        }

        .portal-container.sidebar-hidden main.dashboard-view {
            margin-left: 0;
        }

        /* HEADER */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
        }

        .header-left-zone {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .sidebar-toggle-btn {
            background: var(--pure-white);
            color: var(--bamboo-dark);
            border: 1px solid rgba(0, 0, 0, 0.06);
            width: 48px;
            height: 48px;
            border-radius: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
            transition: var(--transition-smooth);
            flex-shrink: 0;
        }

        .sidebar-toggle-btn:hover {
            transform: translateY(-1px);
            background-color: #FAFAFA;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
        }

        .dashboard-header h2 {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -1px;
            line-height: 1.2;
        }

        /* ==========================================
           MODIFIED: HIGH-VISIBILITY ROLE SWITCHER
           ========================================== */
        .role-switcher-container {
            position: relative;
            display: inline-block;
            z-index: 500;
            user-select: none;
        }

        .role-trigger-btn {
            background: var(--pure-white);
            border: 2px solid rgba(0, 0, 0, 0.06);
            border-radius: 40px;
            padding: 12px 28px;
            display: flex;
            align-items: center;
            gap: 16px;
            text-align: left;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.04);
            transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
        }

        /* 可切换状态下的悬浮和光标样式 */
        .role-trigger-btn.interactive-role {
            cursor: pointer;
        }

        .role-trigger-btn.interactive-role:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(30, 53, 36, 0.08);
        }

        /* 🔒 核心修改点：单角色锁定状态下的样式 (去掉手势与动画，彻底不响应任何点击) */
        .role-trigger-btn.static-role {
            cursor: default;
            pointer-events: none;
        }

        .role-indicator-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            position: relative;
            transition: var(--transition-smooth);
        }

        /* Distinct Color Dot States */
        .mode-user { background-color: #4A8B5B; box-shadow: 0 0 12px rgba(74, 139, 91, 0.6); }
        .mode-admin { background-color: #D94E4E; box-shadow: 0 0 12px rgba(217, 78, 78, 0.6); }
        .mode-property { background-color: #3B7197; box-shadow: 0 0 12px rgba(59, 113, 151, 0.6); }

        .role-btn-text {
            display: flex;
            flex-direction: column;
        }

        .role-subtext {
            font-size: 0.7rem;
            font-weight: 800;
            color: #8C9C93;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            line-height: 1;
            margin-bottom: 3px;
        }

        .role-maintext {
            font-size: 1.2rem; /* ENLARGED: 从原先小字号升级为大字号 */
            font-weight: 800;
            color: var(--bamboo-dark);
            line-height: 1.1;
            transition: var(--transition-smooth);
        }

        .dropdown-chevron {
            color: #7A8B80;
            transition: transform 0.3s ease;
            margin-left: 8px;
        }

        /* DYNAMIC TRIGGER STATUS SKINS (Changes entire button color profile based on active role) */
        .role-trigger-btn.trigger-skin-user {
            border-color: rgba(74, 139, 91, 0.4);
            background-color: rgba(74, 139, 91, 0.05);
        }
        .role-trigger-btn.trigger-skin-user .role-maintext { color: #2E5B3A; }
        .role-trigger-btn.trigger-skin-user .role-subtext { color: #5A7264; }

        .role-trigger-btn.trigger-skin-admin {
            border-color: rgba(217, 78, 78, 0.4);
            background-color: rgba(217, 78, 78, 0.06);
        }
        .role-trigger-btn.trigger-skin-admin .role-maintext { color: #B53535; }
        .role-trigger-btn.trigger-skin-admin .role-subtext { color: #9E5858; }

        .role-trigger-btn.trigger-skin-property {
            border-color: rgba(59, 113, 151, 0.4);
            background-color: rgba(59, 113, 151, 0.06);
        }
        .role-trigger-btn.trigger-skin-property .role-maintext { color: #255173; }
        .role-trigger-btn.trigger-skin-property .role-subtext { color: #536F85; }

        /* DROPDOWN MENU */
        .role-dropdown-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 320px;
            background: var(--pure-white);
            border-radius: 20px;
            padding: 10px;
            box-shadow: 0 20px 50px rgba(30, 53, 36, 0.12);
            border: 1px solid rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
            gap: 6px;
            opacity: 0;
            transform: translateY(-12px) scale(0.97);
            pointer-events: none;
            transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .role-switcher-container.menu-open .role-dropdown-menu {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }

        .role-switcher-container.menu-open .dropdown-chevron {
            transform: rotate(180deg);
        }

        .role-option {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 12px 16px;
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.25s ease;
            border: 1px solid transparent;
        }

        .option-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.25s ease;
        }

        .option-details h6 {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--bamboo-dark);
        }

        .option-details p {
            font-size: 0.75rem;
            color: #7A8B80;
            margin-top: 1px;
            line-height: 1.3;
        }

        .item-user:hover, .role-option.active.item-user {
            background: rgba(74, 139, 91, 0.05);
            border-color: rgba(74, 139, 91, 0.15);
        }
        .item-user .option-icon { background: rgba(74, 139, 91, 0.08); color: #4A8B5B; }

        .item-admin:hover, .role-option.active.item-admin {
            background: rgba(217, 78, 78, 0.05);
            border-color: rgba(217, 78, 78, 0.15);
        }
        .item-admin .option-icon { background: rgba(217, 78, 78, 0.08); color: #D94E4E; }

        .item-property:hover, .role-option.active.item-property {
            background: rgba(59, 113, 151, 0.05);
            border-color: rgba(59, 113, 151, 0.15);
        }
        .item-property .option-icon { background: rgba(59, 113, 151, 0.08); color: #3B7197; }

        .role-option.active {
            background-color: #F8FAF9 !important;
            box-shadow: inset 3px 0 0 var(--bamboo-stalk);
        }
        .role-option.active.item-admin { box-shadow: inset 3px 0 0 #D94E4E; }
        .role-option.active.item-property { box-shadow: inset 3px 0 0 #3B7197; }

        /* METRIC CARDS */
        .stat-bar {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .resident-status-card {
            background: var(--pure-white);
            border-radius: var(--card-radius);
            padding: 1.5rem;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(0, 0, 0, 0.03);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            transition: var(--transition-smooth);
        }

        .resident-status-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 35px rgba(74, 139, 91, 0.06);
        }

        .card-icon-pill {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: rgba(74, 139, 91, 0.08);
            color: var(--bamboo-stalk);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
        }

        .resident-status-card.alert-variant .card-icon-pill {
            background: rgba(226, 135, 67, 0.1);
            color: var(--warm-earth);
        }

        .resident-card-label {
            font-size: 0.8rem;
            font-weight: 700;
            color: #7A8B80;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .resident-card-value {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--bamboo-dark);
            margin-top: 4px;
        }

        /* GRID CONTENT SYSTEM */
        .grid-layout {
            display: grid;
            grid-template-columns: 1.5fr 1.1fr;
            gap: 2rem;
            align-items: start;
        }

        .resident-dashboard-card {
            background: var(--pure-white);
            border-radius: var(--card-radius);
            padding: 2rem;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(0,0,0,0.02);
            margin-bottom: 2rem;
        }

        .card-header-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.8rem;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--bamboo-dark);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.2rem;
            background: var(--bamboo-shoot);
            border-radius: 16px;
            margin-bottom: 1rem;
            border: 1px solid rgba(0, 0, 0, 0.01);
            transition: var(--transition-smooth);
        }

        .item-row:hover {
            background: var(--pure-white);
            box-shadow: 0 8px 20px rgba(0,0,0,0.03);
            border-color: rgba(74, 139, 91, 0.15);
        }

        .item-row.alert-active {
            border-left: 4px solid var(--warm-earth);
        }

        .badge-pill {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 30px;
        }

        .badge-pill-success {
            background: rgba(74, 139, 91, 0.1);
            color: var(--bamboo-stalk);
        }

        .badge-pill-warning {
            background: rgba(226, 135, 67, 0.12);
            color: var(--warm-earth);
        }

        /* TIMELINE COMPONENT */
        .tracker-wrapper {
            margin-top: 12px;
            display: flex;
            justify-content: space-between;
            position: relative;
            padding: 0 10px;
        }

        .tracker-line {
            position: absolute;
            top: 10px;
            left: 20px;
            right: 20px;
            height: 3px;
            background: #E6ECE8;
            z-index: 1;
        }

        .tracker-node {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: var(--pure-white);
            border: 3px solid #D2DDD6;
            z-index: 2;
        }

        .tracker-node.complete {
            background: var(--bamboo-stalk);
            border-color: var(--bamboo-stalk);
        }

        .tracker-node.current {
            background: var(--warm-earth);
            border-color: var(--warm-earth);
        }
    </style>
</head>
<body>

<div class="portal-container" id="portalContainer">
    
    <!-- FIXED NAVIGATION SIDEBAR -->
    <aside class="navigation-panel">
        <div class="brand-section">
            <h1>Resi<span>Sync</span></h1>
        </div>

        <!-- SIDEBAR USER PROFILE ROLE ZONE -->
        <div class="user-anchor">
            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=150" alt="Resident Avatar">
            <div class="user-details">
                <h4>User 1</h4>
                <div class="role-indicator-container" id="sidebarRoleContainer">
                    <!-- Initial role matches dynamic PHP-selected state -->
                    <span class="sidebar-role-badge <?php echo $sidebarRoleBadgeClass; ?>" id="sidebarRoleLabel"><?php echo $activeRoleLabel; ?></span>
                    <span>&bull; C-14-03A</span>
                </div>
            </div>
        </div>

        <nav class="menu-links">
            <a href="#" class="menu-item active">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                My Home
            </a>
            <a href="#" class="menu-item">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z"/></svg>
                Visitor Passes
            </a>
            <a href="#" class="menu-item">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                Book Facilities
            </a>
            <a href="#" class="menu-item">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.67 2.67 0 1021 17.25l-5.83-5.83m-4.95 2.12a7.422 7.422 0 10-5.38-5.38m5.38 5.38l-.66.66m6.04-6.04l.66-.66m0 0A3.375 3.375 0 1011.75 3h.008a3.375 3.375 0 002.508 5.25z"/></svg>
                Report Defect
            </a>
            <a href="#" class="menu-item">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-5.625-12h15.75c.621 0 1.125.504 1.125 1.125v13.5c0 .621-.504 1.125-1.125 1.125H3.375a1.125 1.125 0 01-1.125-1.125V3.375c0-.621.504-1.125 1.125-1.125z"/></svg>
                Bills & Ledger
            </a>
        </nav>

        <button class="logout-btn" onclick="triggerLogout()">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3.003-3h9.75m-9.75 0l3-3m-3 3l3 3"/>
            </svg>
            Logout
        </button>
    </aside>

    <!-- MAIN SCROLLABLE DASHBOARD VIEW -->
    <main class="dashboard-view">
        <header class="dashboard-header">
            <div class="header-left-zone">
                <button class="sidebar-toggle-btn" onclick="toggleSidebar()" aria-label="Toggle Navigation">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                </button>
                <div>
                    <h2>Welcome Back, Jin</h2>
                    <p style="color: #6B7C72; font-weight: 500;">Here's your apartment's status breakdown today</p>
                </div>
            </div>
            
            <!-- ==========================================
               UPDATED: ENLARGED & DYNAMIC ROLE SWITCHER 
               ========================================== -->
            <div class="role-switcher-container">
                <!-- 
                  📢 核心修改点：
                  - 动态生成对应角色（Resident, Admin, Property）的大按钮。
                  - 只要 $hasMultipleRoles 为 false，直接禁掉 onclick 手势，让其变为不可点的纯展示牌 (static-role)。
                -->
                <button 
                    class="role-trigger-btn <?php echo $activeTriggerSkin; ?> <?php echo $hasMultipleRoles ? 'interactive-role' : 'static-role'; ?>" 
                    id="roleTriggerBtn" 
                    <?php echo $hasMultipleRoles ? 'onclick="toggleRoleDropdown()"' : ''; ?>
                >
                    <span class="role-indicator-dot <?php echo $activeRoleClass; ?>"></span>
                    <div class="role-btn-text">
                        <span class="role-subtext">Active Role</span>
                        <span class="role-maintext" id="activeRoleText"><?php echo $activeRoleLabel; ?></span>
                    </div>
                    
                    <!-- 📢 修改点 2：只有在拥有多个角色时，才渲染下拉箭头，单角色直接隐形 -->
                    <?php if ($hasMultipleRoles): ?>
                        <svg class="dropdown-chevron" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                        </svg>
                    <?php endif; ?>
                </button>

                <!-- 📢 修改点 3：如果只有一个角色，前端直接不吐出下拉菜单 HTML，从代码级别移除所有备用选项 -->
                <?php if ($hasMultipleRoles): ?>
                    <div class="role-dropdown-menu" id="roleDropdownMenu">
                        <div class="role-option item-user <?php echo $activeRole === 'resident' ? 'active' : ''; ?>" onclick="selectRole('user', 'Resident', 'mode-user', 'trigger-skin-user')">
                            <div class="option-icon">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                            </div>
                            <div class="option-details">
                                <h6>Resident</h6>
                                <p>Personal profile, statements, and keycards</p>
                            </div>
                        </div>

                        <div class="role-option item-admin <?php echo $activeRole === 'admin' ? 'active' : ''; ?>" onclick="selectRole('admin', 'Admin', 'mode-admin', 'trigger-skin-admin')">
                            <div class="option-icon">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.286z"/></svg>
                            </div>
                            <div class="option-details">
                                <h6>Admin</h6>
                                <p>System settings, overrides, and configurations</p>
                            </div>
                        </div>

                        <div class="role-option item-property <?php echo $activeRole === 'property' ? 'active' : ''; ?>" onclick="selectRole('property', 'Property', 'mode-property', 'trigger-skin-property')">
                            <div class="option-icon">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1m1.5-1.5l-3-1m-3.182-5.182a1.5 1.5 0 11-2.122 2.122 1.5 1.5 0 012.122-2.122z"/></svg>
                            </div>
                            <div class="option-details">
                                <h6>Property</h6>
                                <p>Facility tracking and commercial registers</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </header>

        <!-- RESIDENT CARDS ROW -->
        <section class="stat-bar">
            <div class="resident-status-card">
                <div class="card-icon-pill">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div class="resident-card-label">July Statement</div>
                    <div class="resident-card-value" style="color: var(--bamboo-stalk);"><?php echo $residentStats['maintenance_status']; ?></div>
                </div>
            </div>
            
            <div class="resident-status-card">
                <div class="card-icon-pill">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                </div>
                <div>
                    <div class="resident-card-label">Reservations</div>
                    <div class="resident-card-value"><?php echo $residentStats['active_bookings']; ?> Active</div>
                </div>
            </div>

            <div class="resident-status-card alert-variant">
                <div class="card-icon-pill">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25M9 12.25v5.25m6-5.25v5.25"/></svg>
                </div>
                <div>
                    <div class="resident-card-label">Parcel Lockers</div>
                    <div class="resident-card-value" style="color: var(--warm-earth);"><?php echo $residentStats['incoming_parcels']; ?> Pending</div>
                </div>
            </div>

            <div class="resident-status-card">
                <div class="card-icon-pill">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499c-.105-.347-.492-.546-.832-.442a.642.642 0 00-.443.442L8.713 7.425a1.51 1.51 0 01-1.138 1.006l-4.293.57c-.36.047-.604.385-.544.743a.645.645 0 00.18.368l3.199 2.946c.32.296.467.746.392 1.173l-.83 4.23a.645.645 0 00.672.766.643.643 0 00.274-.067l3.774-2.072a1.51 1.51 0 011.458 0l3.774 2.072c.321.176.726.06 0.9-.26a.642.642 0 00.076-.32l-.83-4.23a1.511 1.511 0 01.392-1.173l3.199-2.946a.644.644 0 00-.172-1.042l-4.293-.57a1.51 1.51 0 01-1.138-1.006L11.48 3.5z"/></svg>
                </div>
                <div>
                    <div class="resident-card-label">Eco Rewards</div>
                    <div class="resident-card-value"><?php echo $residentStats['community_points']; ?> pts</div>
                </div>
            </div>
        </section>

        <!-- LAYOUT GRID CONTAINER -->
        <div class="grid-layout">
            <div class="left-col">
                <div class="resident-dashboard-card">
                    <div class="card-header-group">
                        <div class="card-title">
                            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 00-6.338 0 .225.225 0 00-.108.232c.026.37.332.657.702.657h5.044a.75.75 0 00.702-.657.225.225 0 00-.108-.232z"/></svg>
                            Active Visitor Access Keys
                        </div>
                    </div>

                    <?php foreach($visitorLogs as $log): ?>
                        <div class="item-row <?php echo $log['overstay'] ? 'alert-active' : ''; ?>">
                            <div>
                                <h5 style="font-weight: 700; font-size: 0.95rem;"><?php echo htmlspecialchars($log['name']); ?></h5>
                                <div style="margin-top: 4px; font-size: 0.8rem; color:#6B7C72;">
                                    <span style="font-weight:700; margin-right:8px;"><?php echo htmlspecialchars($log['plate']); ?></span>
                                    &bull; <span style="margin-left:4px;"><?php echo $log['type']; ?></span>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <?php if($log['overstay']): ?>
                                    <span class="badge-pill badge-pill-warning">Overstay Alert</span>
                                <?php else: ?>
                                    <span class="badge-pill badge-pill-success">Active Pass</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="resident-dashboard-card">
                    <div class="card-header-group">
                        <div class="card-title">
                            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 21l8.954-8.955c.44-.439 1.152-.439 1.591 0L21 13.341m0 0l-3.66 3.66m3.66-3.66l-5.83-5.83m-4.95 2.12a7.422 7.422 0 10-5.38-5.38m5.38 5.38l-.66.66m6.04-6.04l.66-.66"/></svg>
                            My Facility & Asset Bookings
                        </div>
                    </div>

                    <?php foreach($activeBookings as $booking): ?>
                        <div class="item-row">
                            <div>
                                <h5 style="font-weight: 700; font-size: 0.95rem;"><?php echo htmlspecialchars($booking['resource']); ?></h5>
                                <p style="font-size: 0.8rem; color: var(--bamboo-stalk); font-weight: 600; margin-top: 2px;"><?php echo $booking['time']; ?></p>
                            </div>
                            <span class="badge-pill" style="background: rgba(0,0,0,0.05); font-weight:700; font-size:0.7rem; text-transform:uppercase;"><?php echo $booking['type']; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="right-col">
                <div class="resident-dashboard-card">
                    <div class="card-header-group">
                        <div class="card-title">
                            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                            Maintenance Tickets
                        </div>
                    </div>

                    <?php foreach($defectTickets as $ticket): ?>
                        <div style="border: 1px solid #E6ECE8; border-radius: 16px; padding: 1.2rem; margin-bottom: 1rem;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                                <div>
                                    <h5 style="font-weight: 700; font-size: 0.95rem;"><?php echo htmlspecialchars($ticket['title']); ?></h5>
                                    <span style="font-size: 0.75rem; color: #7A8B80; font-weight: 600;"><?php echo $ticket['id']; ?> &bull; <?php echo $ticket['location']; ?></span>
                                </div>
                                <span class="badge-pill <?php echo $ticket['urgency'] === 'High' ? 'badge-pill-warning' : 'badge-pill-success'; ?>">
                                    <?php echo $ticket['urgency']; ?>
                                </span>
                            </div>

                            <div class="tracker-wrapper">
                                <div class="tracker-line"></div>
                                <div class="tracker-node complete"></div>
                                <div class="tracker-node <?php echo $ticket['state'] === 'Assigned' ? 'complete' : 'current'; ?>"></div>
                                <div class="tracker-node"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="resident-dashboard-card">
                    <div class="card-header-group">
                        <div class="card-title">
                            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                            Community Updates
                        </div>
                    </div>

                    <?php foreach($bulletinBoard as $post): ?>
                        <div style="margin-bottom: 1.2rem; padding-bottom: 1.2rem; border-bottom: 1px dashed #E6ECE8;">
                            <span style="font-size: 0.7rem; font-weight: 800; color: var(--bamboo-stalk); text-transform: uppercase;"><?php echo $post['tag']; ?> &bull; <?php echo $post['date']; ?></span>
                            <h5 style="font-weight: 700; font-size: 0.95rem; margin: 2px 0 6px 0;"><?php echo htmlspecialchars($post['title']); ?></h5>
                            <p style="font-size: 0.85rem; color: #55665C; line-height: 1.4;"><?php echo htmlspecialchars($post['content']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    function toggleSidebar() {
        const container = document.getElementById('portalContainer');
        container.classList.toggle('sidebar-hidden');
    }

    function toggleRoleDropdown() {
        const container = document.querySelector('.role-switcher-container');
        if (container) {
            container.classList.toggle('menu-open');
        }
    }

    // UPDATED PIPELINE: Dynamic high-visibility state synchronization
    function selectRole(roleValue, roleLabel, customDotClass, triggerSkinClass) {
        // 1. Update Dropdown Trigger View text & style profiles
        const activeTextEl = document.getElementById('activeRoleText');
        if (activeTextEl) activeTextEl.innerText = roleLabel;
        
        // 2. Update the Indicator Dot color schema inside the switcher
        const dot = document.querySelector('.role-trigger-btn .role-indicator-dot');
        if (dot) dot.className = 'role-indicator-dot ' + customDotClass;
        
        // 3. Update the button wrapper skin class for comprehensive state colors
        const triggerBtn = document.getElementById('roleTriggerBtn');
        if (triggerBtn) {
            // Keep interactive-role style if count > 1
            triggerBtn.className = 'role-trigger-btn interactive-role ' + triggerSkinClass;
        }
        
        // 4. Highlight current selected block inside active popup options list
        document.querySelectorAll('.role-dropdown-menu .role-option').forEach(element => {
            element.classList.remove('active');
        });
        const targetOption = document.querySelector('.role-dropdown-menu .item-' + roleValue);
        if (targetOption) targetOption.classList.add('active');

        // 5. Update Left Sidebar Profile Info dynamically
        const sidebarRoleLabel = document.getElementById('sidebarRoleLabel');
        if (sidebarRoleLabel) {
            if (roleValue === 'user') {
                sidebarRoleLabel.innerText = 'Resident';
                sidebarRoleLabel.className = 'sidebar-role-badge badge-user';
            } else if (roleValue === 'admin') {
                sidebarRoleLabel.innerText = 'Admin';
                sidebarRoleLabel.className = 'sidebar-role-badge badge-admin';
            } else if (roleValue === 'property') {
                sidebarRoleLabel.innerText = 'Property';
                sidebarRoleLabel.className = 'sidebar-role-badge badge-property';
            }
        }

        // Close dropdown securely
        const switcherContainer = document.querySelector('.role-switcher-container');
        if (switcherContainer) switcherContainer.classList.remove('menu-open');
        
        if (typeof handleModeChange === "function") {
            handleModeChange(roleValue);
        }
    }

    function handleModeChange(selectedMode) {
        console.log("Interface context updated to: " + selectedMode);
    }

    function triggerLogout() {
        if (confirm("Are you sure you want to log out of ResiSync?")) {
            alert("Logging out successfully... Redirecting to portal.");
        }
    }

    // GLOBAL CLICK PIPELINE: Dismiss dropdown securely on blur
    window.addEventListener('click', function(e) {
        const container = document.querySelector('.role-switcher-container');
        if (container && !container.contains(e.target)) {
            container.classList.remove('menu-open');
        }
    });
</script>

</body>
</html>