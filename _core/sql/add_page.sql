-- Template: tilføj ny side til menu og giv adgang til roller
-- Erstat værdierne nedenfor og kør:
--   mysql -u root -p zumardb < _core/sql/add_page.sql

-- 1) Opret topmenu (spring over hvis siden skal under eksisterende menu)
INSERT INTO topmenu (name, accessname, href, icon, submenu, sort, deleted, createdtime)
SELECT 'Mit modul', 'My module', 'mymodule', 'icon-folder', 1, 30, 0, NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM topmenu WHERE href = 'mymodule' AND deleted = 0
);

SET @menu_id := (
    SELECT id FROM topmenu WHERE href = 'mymodule' AND deleted = 0 ORDER BY id DESC LIMIT 1
);

-- 2) Opret side (href = filnavn uden .php, fx mypage.php -> mypage)
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted, createdtime)
SELECT 'fa-file', 'Min side', 'My page', 'mypage', @menu_id, 1, 10, 0, NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM pages WHERE href = 'mypage' AND deleted = 0
);

-- 3) Giv view-adgang til rolle 2 (standard user)
INSERT INTO pagepermissions (roleid, pageid, permissionid, view, edit, del, code, createdtime, deleted)
SELECT 2, p.id, 1, 1, 0, 0, CONCAT('2-', p.id), NOW(), 0
FROM pages p
WHERE p.deleted = 0
  AND p.href = 'mypage'
  AND @menu_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM pagepermissions pp
      WHERE pp.deleted = 0 AND pp.roleid = 2 AND pp.pageid = p.id
  );
