-- zumar.bulsho.net — auth schema + Zumar Foundation program database
-- Usage:
--   mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS zumardb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
--   mysql -u root -p zumardb < _core/sql/install.sql
--
-- Default login after install:
--   username: admin
--   password: admin123

SET NAMES utf8mb4;
SET time_zone = '+03:00';

CREATE TABLE IF NOT EXISTS roles (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    rolename VARCHAR(100) NOT NULL,
    remark VARCHAR(255) DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS statuss (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    statusname VARCHAR(100) NOT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS permissions (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    permissionname VARCHAR(100) NOT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS topmenu (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    accessname VARCHAR(100) DEFAULT NULL,
    href VARCHAR(100) NOT NULL,
    icon VARCHAR(100) DEFAULT 'icon-home',
    submenu TINYINT(1) NOT NULL DEFAULT 0,
    sort INT NOT NULL DEFAULT 0,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_topmenu_href (href)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS pages (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    fa VARCHAR(50) DEFAULT 'fa-circle',
    pagename VARCHAR(150) NOT NULL,
    accesspagename VARCHAR(150) DEFAULT NULL,
    href VARCHAR(100) NOT NULL,
    topmenuid INT UNSIGNED NOT NULL DEFAULT 1,
    sidebar TINYINT(1) NOT NULL DEFAULT 1,
    sort INT NOT NULL DEFAULT 0,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_pages_href (href),
    KEY idx_pages_topmenu (topmenuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS pagepermissions (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    roleid INT UNSIGNED NOT NULL,
    pageid INT UNSIGNED NOT NULL,
    permissionid INT UNSIGNED NOT NULL DEFAULT 1,
    view TINYINT(1) NOT NULL DEFAULT 1,
    edit TINYINT(1) NOT NULL DEFAULT 0,
    del TINYINT(1) NOT NULL DEFAULT 0,
    code VARCHAR(50) DEFAULT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_pp_role_page (roleid, pageid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) DEFAULT NULL,
    salt VARCHAR(64) DEFAULT NULL,
    lastp VARCHAR(255) DEFAULT NULL,
    name VARCHAR(150) DEFAULT NULL,
    employeeid INT UNSIGNED NOT NULL DEFAULT 0,
    agentid INT UNSIGNED NOT NULL DEFAULT 0,
    roleid INT UNSIGNED NOT NULL DEFAULT 1,
    statusid INT UNSIGNED NOT NULL DEFAULT 1,
    photourl VARCHAR(255) DEFAULT NULL,
    defaultpwd VARCHAR(255) DEFAULT NULL,
    lastlogin DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uk_users_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS users_session (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    username VARCHAR(50) DEFAULT NULL,
    hash VARCHAR(255) NOT NULL,
    logintime DATETIME DEFAULT NULL,
    PRIMARY KEY (id),
    KEY idx_users_session_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Roles
INSERT INTO roles (id, rolename, remark, deleted)
SELECT 1, 'Administrator', 'Full access', 0
WHERE NOT EXISTS (SELECT 1 FROM roles WHERE id = 1);

INSERT INTO roles (id, rolename, remark, deleted)
SELECT 2, 'User', 'Standard user', 0
WHERE NOT EXISTS (SELECT 1 FROM roles WHERE id = 2);

-- Status
INSERT INTO statuss (id, statusname, deleted)
SELECT 1, 'Active', 0
WHERE NOT EXISTS (SELECT 1 FROM statuss WHERE id = 1);

INSERT INTO statuss (id, statusname, deleted)
SELECT 2, 'Inactive', 0
WHERE NOT EXISTS (SELECT 1 FROM statuss WHERE id = 2);

-- Permission types
INSERT INTO permissions (id, permissionname, deleted)
SELECT 1, 'View', 0
WHERE NOT EXISTS (SELECT 1 FROM permissions WHERE id = 1);

-- Top menu: Home + Examples submenu
INSERT INTO topmenu (id, name, accessname, href, icon, submenu, sort, deleted)
SELECT 1, 'Baga Bilowga', 'Home', 'dashboard', 'icon-home', 0, 1, 0
WHERE NOT EXISTS (SELECT 1 FROM topmenu WHERE href = 'dashboard' AND deleted = 0);

INSERT INTO topmenu (id, name, accessname, href, icon, submenu, sort, deleted)
SELECT 2, 'Tusaalo', 'Examples', 'examples', 'icon-list', 1, 20, 0
WHERE NOT EXISTS (SELECT 1 FROM topmenu WHERE href = 'examples' AND deleted = 0);

-- Pages (href uden .php — matcher activesitename())
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-home', 'Baga Bilowga', 'Home', 'dashboard', 1, 0, 1, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'dashboard' AND deleted = 0);

INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-list', 'Tusaale liis', 'Example list', 'example-page', 2, 1, 10, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'example-page' AND deleted = 0);

INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-lock', 'Badal password', 'Change password', 'changepassword', 1, 0, 99, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'changepassword' AND deleted = 0);

-- Standard user (role 2) may access default pages
INSERT INTO pagepermissions (roleid, pageid, permissionid, view, edit, del, code, deleted)
SELECT 2, p.id, 1, 1, 0, 0, CONCAT('2-', p.id), 0
FROM pages p
WHERE p.deleted = 0
  AND p.href IN ('dashboard', 'example-page', 'changepassword')
  AND NOT EXISTS (
      SELECT 1 FROM pagepermissions pp
      WHERE pp.deleted = 0 AND pp.roleid = 2 AND pp.pageid = p.id
  );

-- Admin user (role 1 bypasses pagepermissions in head.php)
INSERT INTO users (username, password, salt, lastp, name, employeeid, roleid, statusid, deleted)
SELECT 'admin', '', 'templatesalt', 'admin123', 'Administrator', 0, 1, 1, 0
WHERE NOT EXISTS (SELECT 1 FROM users WHERE username = 'admin' AND deleted = 0);
