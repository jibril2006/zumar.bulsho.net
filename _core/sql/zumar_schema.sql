-- Zumar Foundation program tables, reference data, roles and menu
-- Imported after install.sql into zumardb

SET NAMES utf8mb4;
SET time_zone = '+03:00';

-- ---------------------------------------------------------------------------
-- Org roles from guideline 15.2 (keep 1 Administrator, 2 User)
-- ---------------------------------------------------------------------------
INSERT INTO roles (id, rolename, remark, deleted)
SELECT 3, 'Executive Director', 'Full read, approval override', 0
WHERE NOT EXISTS (SELECT 1 FROM roles WHERE id = 3);
INSERT INTO roles (id, rolename, remark, deleted)
SELECT 4, 'Admin & Finance Manager', 'Finance read/write', 0
WHERE NOT EXISTS (SELECT 1 FROM roles WHERE id = 4);
INSERT INTO roles (id, rolename, remark, deleted)
SELECT 5, 'Finance Expert', 'Finance read/write', 0
WHERE NOT EXISTS (SELECT 1 FROM roles WHERE id = 5);
INSERT INTO roles (id, rolename, remark, deleted)
SELECT 6, 'Chief Accountant', 'Finance read/write', 0
WHERE NOT EXISTS (SELECT 1 FROM roles WHERE id = 6);
INSERT INTO roles (id, rolename, remark, deleted)
SELECT 7, 'Program Coordinator', 'Program modules for assigned projects', 0
WHERE NOT EXISTS (SELECT 1 FROM roles WHERE id = 7);
INSERT INTO roles (id, rolename, remark, deleted)
SELECT 8, 'Project Manager', 'Program modules for assigned projects', 0
WHERE NOT EXISTS (SELECT 1 FROM roles WHERE id = 8);
INSERT INTO roles (id, rolename, remark, deleted)
SELECT 9, 'Field Manager', 'Field data entry for assigned projects', 0
WHERE NOT EXISTS (SELECT 1 FROM roles WHERE id = 9);
INSERT INTO roles (id, rolename, remark, deleted)
SELECT 10, 'HR Manager', 'HR and MEAL', 0
WHERE NOT EXISTS (SELECT 1 FROM roles WHERE id = 10);
INSERT INTO roles (id, rolename, remark, deleted)
SELECT 11, 'HR Administrator', 'HR administration', 0
WHERE NOT EXISTS (SELECT 1 FROM roles WHERE id = 11);
INSERT INTO roles (id, rolename, remark, deleted)
SELECT 12, 'M&E Officer', 'MEAL + cross-project indicator reports', 0
WHERE NOT EXISTS (SELECT 1 FROM roles WHERE id = 12);
INSERT INTO roles (id, rolename, remark, deleted)
SELECT 13, 'Operations Manager', 'Procurement approval', 0
WHERE NOT EXISTS (SELECT 1 FROM roles WHERE id = 13);
INSERT INTO roles (id, rolename, remark, deleted)
SELECT 14, 'Procurement Officer', 'Procurement read/write', 0
WHERE NOT EXISTS (SELECT 1 FROM roles WHERE id = 14);
INSERT INTO roles (id, rolename, remark, deleted)
SELECT 15, 'Civil Work Officer', 'Infrastructure field records', 0
WHERE NOT EXISTS (SELECT 1 FROM roles WHERE id = 15);

-- ---------------------------------------------------------------------------
-- Master reference
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS zf_countries (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    country_code CHAR(2) NOT NULL,
    country_name VARCHAR(100) NOT NULL,
    currency VARCHAR(10) NOT NULL,
    timezone VARCHAR(50) NOT NULL DEFAULT 'EAT',
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    UNIQUE KEY uk_zf_countries_code (country_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_locations (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    location_code VARCHAR(40) NOT NULL,
    country_code CHAR(2) NOT NULL,
    region_state VARCHAR(150) DEFAULT NULL,
    district VARCHAR(150) NOT NULL,
    gps_coordinates VARCHAR(100) DEFAULT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    UNIQUE KEY uk_zf_locations_code (location_code),
    KEY idx_zf_locations_country (country_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_sectors (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    sector_code VARCHAR(8) NOT NULL,
    sector_name VARCHAR(150) NOT NULL,
    sector_lead_role VARCHAR(100) DEFAULT NULL,
    linked_sdgs VARCHAR(255) DEFAULT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    UNIQUE KEY uk_zf_sectors_code (sector_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_partners (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    partner_code VARCHAR(20) NOT NULL,
    partner_name VARCHAR(200) NOT NULL,
    partner_type VARCHAR(50) NOT NULL,
    relationship VARCHAR(80) NOT NULL,
    country_of_registration VARCHAR(100) DEFAULT NULL,
    status VARCHAR(40) NOT NULL DEFAULT 'Active',
    notes TEXT,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    UNIQUE KEY uk_zf_partners_code (partner_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_hr_policies (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    policy_name VARCHAR(200) NOT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_projects (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    project_code VARCHAR(40) NOT NULL,
    project_name VARCHAR(255) NOT NULL,
    country_code CHAR(2) NOT NULL,
    sector_code VARCHAR(8) NOT NULL,
    location_id INT UNSIGNED DEFAULT NULL,
    year SMALLINT UNSIGNED NOT NULL,
    sequence_no INT UNSIGNED NOT NULL DEFAULT 1,
    start_date DATE DEFAULT NULL,
    end_date DATE DEFAULT NULL,
    status VARCHAR(40) NOT NULL DEFAULT 'Planned',
    description TEXT,
    linked_sdgs VARCHAR(255) DEFAULT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    UNIQUE KEY uk_zf_projects_code (project_code),
    KEY idx_zf_projects_country_sector (country_code, sector_code, year)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_staff (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    staff_code VARCHAR(30) NOT NULL,
    full_name VARCHAR(200) NOT NULL,
    position VARCHAR(120) NOT NULL,
    reports_to INT UNSIGNED DEFAULT NULL,
    country_code CHAR(2) NOT NULL,
    contract_start DATE DEFAULT NULL,
    contract_end DATE DEFAULT NULL,
    employment_status VARCHAR(40) NOT NULL DEFAULT 'Active',
    user_id INT UNSIGNED DEFAULT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    UNIQUE KEY uk_zf_staff_code (staff_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------------
-- Program: Orphan Support
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS zf_orphans (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    orphan_code VARCHAR(40) NOT NULL,
    serial_no INT UNSIGNED NOT NULL,
    full_name VARCHAR(200) NOT NULL,
    gender VARCHAR(20) NOT NULL,
    date_of_birth DATE DEFAULT NULL,
    age TINYINT UNSIGNED NOT NULL DEFAULT 0,
    country_code CHAR(2) NOT NULL,
    location_id INT UNSIGNED NOT NULL,
    year_enrolled SMALLINT UNSIGNED NOT NULL,
    guardian_name VARCHAR(200) DEFAULT NULL,
    photo VARCHAR(255) DEFAULT NULL,
    photo_caption VARCHAR(255) DEFAULT NULL,
    photo_date DATE DEFAULT NULL,
    photo_gps VARCHAR(100) DEFAULT NULL,
    consent_flag TINYINT(1) NOT NULL DEFAULT 0,
    project_id INT UNSIGNED NOT NULL,
    status VARCHAR(40) NOT NULL DEFAULT 'Active',
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    UNIQUE KEY uk_zf_orphans_code (orphan_code),
    KEY idx_zf_orphans_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_orphan_education (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    orphan_id INT UNSIGNED NOT NULL,
    school_level VARCHAR(40) NOT NULL,
    grade_class VARCHAR(50) DEFAULT NULL,
    school_name VARCHAR(200) DEFAULT NULL,
    attendance_status VARCHAR(40) NOT NULL,
    date_recorded DATE NOT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_zf_orphan_edu (orphan_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_orphan_support (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    orphan_id INT UNSIGNED NOT NULL,
    quarter VARCHAR(20) NOT NULL,
    support_type VARCHAR(255) NOT NULL,
    support_status VARCHAR(40) NOT NULL,
    amount_disbursed DECIMAL(12,2) DEFAULT NULL,
    verified_by INT UNSIGNED NOT NULL,
    verification_date DATE NOT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_zf_orphan_support (orphan_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_sponsors (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    sponsor_code VARCHAR(30) DEFAULT NULL,
    sponsor_name VARCHAR(200) DEFAULT NULL,
    orphan_id INT UNSIGNED DEFAULT NULL,
    sponsorship_start DATE DEFAULT NULL,
    monthly_amount DECIMAL(12,2) DEFAULT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------------
-- Education
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS zf_school_distributions (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    distribution_code VARCHAR(40) NOT NULL,
    project_id INT UNSIGNED NOT NULL,
    school_name VARCHAR(200) NOT NULL,
    location_id INT UNSIGNED NOT NULL,
    distribution_date DATE NOT NULL,
    items_distributed TEXT,
    no_of_students_reached INT UNSIGNED NOT NULL DEFAULT 0,
    girls_count INT UNSIGNED DEFAULT NULL,
    boys_count INT UNSIGNED DEFAULT NULL,
    photos VARCHAR(255) DEFAULT NULL,
    distributed_by INT UNSIGNED DEFAULT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    UNIQUE KEY uk_zf_edu_dist_code (distribution_code),
    KEY idx_zf_edu_dist_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_education_items (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    distribution_id INT UNSIGNED NOT NULL,
    item_name VARCHAR(100) NOT NULL,
    unit VARCHAR(40) NOT NULL DEFAULT 'piece',
    quantity INT UNSIGNED NOT NULL DEFAULT 0,
    unit_cost DECIMAL(12,2) DEFAULT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_zf_edu_items_dist (distribution_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_scholarships (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    scholarship_code VARCHAR(40) NOT NULL,
    student_name VARCHAR(200) NOT NULL,
    is_orphan TINYINT(1) NOT NULL DEFAULT 0,
    orphan_id INT UNSIGNED DEFAULT NULL,
    education_level VARCHAR(40) NOT NULL,
    field_of_talent VARCHAR(150) DEFAULT NULL,
    amount_awarded DECIMAL(12,2) NOT NULL DEFAULT 0,
    academic_year VARCHAR(20) NOT NULL,
    project_id INT UNSIGNED NOT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    UNIQUE KEY uk_zf_scholarships_code (scholarship_code),
    KEY idx_zf_scholarships_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------------
-- WASH
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS zf_water_points (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    water_point_code VARCHAR(50) NOT NULL,
    project_id INT UNSIGNED NOT NULL,
    water_point_type VARCHAR(60) NOT NULL,
    country_code CHAR(2) NOT NULL,
    location_id INT UNSIGNED NOT NULL,
    date_established DATE NOT NULL,
    depth_meters DECIMAL(8,2) DEFAULT NULL,
    estimated_lifespan_years TINYINT UNSIGNED DEFAULT NULL,
    no_of_beneficiaries INT UNSIGNED NOT NULL DEFAULT 0,
    households_served INT UNSIGNED DEFAULT NULL,
    gps_coordinates VARCHAR(100) NOT NULL,
    photos VARCHAR(255) DEFAULT NULL,
    videos VARCHAR(255) DEFAULT NULL,
    status VARCHAR(40) NOT NULL DEFAULT 'Functional',
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    UNIQUE KEY uk_zf_water_code (water_point_code),
    KEY idx_zf_water_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_water_maintenance (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    water_point_id INT UNSIGNED NOT NULL,
    maintenance_date DATE NOT NULL,
    issue_reported VARCHAR(255) DEFAULT NULL,
    action_taken TEXT NOT NULL,
    cost DECIMAL(12,2) DEFAULT NULL,
    technician VARCHAR(150) DEFAULT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_zf_water_maint (water_point_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------------
-- Health
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS zf_health_visits (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    visit_code VARCHAR(40) NOT NULL,
    project_id INT UNSIGNED NOT NULL,
    facility_type VARCHAR(40) NOT NULL,
    location_id INT UNSIGNED NOT NULL,
    visit_date DATE NOT NULL,
    services_provided VARCHAR(255) NOT NULL,
    no_of_patients_seen INT UNSIGNED NOT NULL DEFAULT 0,
    female_count INT UNSIGNED DEFAULT NULL,
    male_count INT UNSIGNED DEFAULT NULL,
    attending_health_worker INT UNSIGNED DEFAULT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    UNIQUE KEY uk_zf_health_visit_code (visit_code),
    KEY idx_zf_health_visits_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_maternal_health (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    project_id INT UNSIGNED NOT NULL,
    service_type VARCHAR(60) NOT NULL,
    beneficiary_name VARCHAR(200) DEFAULT NULL,
    location_id INT UNSIGNED NOT NULL,
    service_date DATE NOT NULL,
    facility_used VARCHAR(200) DEFAULT NULL,
    outcome_notes TEXT,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_zf_maternal_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_disease_control (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    project_id INT UNSIGNED NOT NULL,
    disease_focus VARCHAR(40) NOT NULL,
    intervention_type VARCHAR(120) NOT NULL,
    location_id INT UNSIGNED NOT NULL,
    service_date DATE NOT NULL,
    quantity_or_reach INT UNSIGNED NOT NULL DEFAULT 0,
    no_of_beneficiaries INT UNSIGNED NOT NULL DEFAULT 0,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_zf_disease_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_health_campaigns (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    project_id INT UNSIGNED NOT NULL,
    topic VARCHAR(80) NOT NULL,
    location_id INT UNSIGNED NOT NULL,
    campaign_date DATE NOT NULL,
    no_reached INT UNSIGNED NOT NULL DEFAULT 0,
    delivery_method VARCHAR(60) DEFAULT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_zf_campaigns_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_mental_health (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    project_id INT UNSIGNED NOT NULL,
    location_id INT UNSIGNED NOT NULL,
    session_date DATE NOT NULL,
    session_type VARCHAR(60) NOT NULL,
    no_of_beneficiaries INT UNSIGNED NOT NULL DEFAULT 0,
    partner_id INT UNSIGNED DEFAULT NULL,
    confidentiality_note TEXT NOT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_zf_mental_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_eye_care (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    project_id INT UNSIGNED NOT NULL,
    service_type VARCHAR(60) NOT NULL,
    location_id INT UNSIGNED NOT NULL,
    service_date DATE NOT NULL,
    no_of_beneficiaries INT UNSIGNED NOT NULL DEFAULT 0,
    follow_up_required TINYINT(1) NOT NULL DEFAULT 0,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_zf_eye_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------------
-- Infrastructure, Livelihoods, Relief, Peace
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS zf_infrastructure (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    asset_code VARCHAR(50) NOT NULL,
    project_id INT UNSIGNED NOT NULL,
    asset_type VARCHAR(60) NOT NULL,
    country_code CHAR(2) NOT NULL,
    location_id INT UNSIGNED NOT NULL,
    construction_start_date DATE NOT NULL,
    construction_completion_date DATE DEFAULT NULL,
    capacity INT UNSIGNED DEFAULT NULL,
    no_of_beneficiaries_estimated INT UNSIGNED NOT NULL DEFAULT 0,
    construction_cost DECIMAL(14,2) DEFAULT NULL,
    gps_coordinates VARCHAR(100) NOT NULL,
    photos VARCHAR(255) DEFAULT NULL,
    status VARCHAR(40) NOT NULL DEFAULT 'Planned',
    handover_authority VARCHAR(200) DEFAULT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    UNIQUE KEY uk_zf_infra_code (asset_code),
    KEY idx_zf_infra_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_livelihood_trainings (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    project_id INT UNSIGNED NOT NULL,
    training_type VARCHAR(80) NOT NULL,
    specific_skill VARCHAR(150) DEFAULT NULL,
    target_group VARCHAR(40) DEFAULT NULL,
    location_id INT UNSIGNED NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE DEFAULT NULL,
    no_of_participants INT UNSIGNED NOT NULL DEFAULT 0,
    female_count INT UNSIGNED DEFAULT NULL,
    male_count INT UNSIGNED DEFAULT NULL,
    completion_rate DECIMAL(5,2) DEFAULT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_zf_train_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_livelihood_assets (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    project_id INT UNSIGNED NOT NULL,
    beneficiary_name VARCHAR(200) NOT NULL,
    asset_type VARCHAR(60) NOT NULL,
    quantity INT UNSIGNED NOT NULL DEFAULT 1,
    value_amount DECIMAL(12,2) DEFAULT NULL,
    date_distributed DATE NOT NULL,
    location_id INT UNSIGNED NOT NULL,
    photo VARCHAR(255) DEFAULT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_zf_livasset_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_seed_grants (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    project_id INT UNSIGNED NOT NULL,
    beneficiary_name VARCHAR(200) NOT NULL,
    business_type VARCHAR(150) DEFAULT NULL,
    amount_granted DECIMAL(12,2) NOT NULL DEFAULT 0,
    training_id INT UNSIGNED DEFAULT NULL,
    disbursement_date DATE NOT NULL,
    follow_up_status VARCHAR(40) DEFAULT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_zf_grants_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_relief_distributions (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    distribution_code VARCHAR(40) NOT NULL,
    project_id INT UNSIGNED NOT NULL,
    distribution_type VARCHAR(60) NOT NULL,
    location_id INT UNSIGNED NOT NULL,
    distribution_date DATE NOT NULL,
    no_of_households_reached INT UNSIGNED NOT NULL DEFAULT 0,
    no_of_individuals_reached INT UNSIGNED NOT NULL DEFAULT 0,
    items_included TEXT,
    unit_cost_per_package DECIMAL(12,2) DEFAULT NULL,
    photos VARCHAR(255) DEFAULT NULL,
    distributed_by INT UNSIGNED DEFAULT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    UNIQUE KEY uk_zf_relief_code (distribution_code),
    KEY idx_zf_relief_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_mediation_cases (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    case_code VARCHAR(40) NOT NULL,
    project_id INT UNSIGNED NOT NULL,
    case_type VARCHAR(80) NOT NULL,
    location_id INT UNSIGNED NOT NULL,
    date_opened DATE NOT NULL,
    parties_involved VARCHAR(150) DEFAULT NULL,
    mediator_id INT UNSIGNED NOT NULL,
    sessions_held INT UNSIGNED DEFAULT NULL,
    case_status VARCHAR(40) NOT NULL DEFAULT 'Open',
    resolution_date DATE DEFAULT NULL,
    outcome_summary TEXT,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    UNIQUE KEY uk_zf_mediation_code (case_code),
    KEY idx_zf_mediation_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_dialogue_sessions (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    project_id INT UNSIGNED NOT NULL,
    session_topic VARCHAR(255) NOT NULL,
    location_id INT UNSIGNED NOT NULL,
    session_date DATE NOT NULL,
    groups_represented VARCHAR(255) DEFAULT NULL,
    no_of_participants INT UNSIGNED NOT NULL DEFAULT 0,
    female_count INT UNSIGNED DEFAULT NULL,
    male_count INT UNSIGNED DEFAULT NULL,
    facilitator_id INT UNSIGNED NOT NULL,
    key_outcomes TEXT,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_zf_dialogue_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_legal_aid (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    project_id INT UNSIGNED NOT NULL,
    beneficiary_name VARCHAR(200) NOT NULL,
    vulnerability_category VARCHAR(60) DEFAULT NULL,
    case_nature VARCHAR(255) NOT NULL,
    date_opened DATE NOT NULL,
    legal_aid_provider VARCHAR(200) NOT NULL,
    case_status VARCHAR(40) NOT NULL DEFAULT 'Ongoing',
    referral_institution VARCHAR(200) DEFAULT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_zf_legal_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------------
-- Finance (Project_ID NOT NULL)
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS zf_budgets (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    project_id INT UNSIGNED NOT NULL,
    budget_line VARCHAR(200) NOT NULL,
    budgeted_amount DECIMAL(14,2) NOT NULL DEFAULT 0,
    currency VARCHAR(10) NOT NULL DEFAULT 'USD',
    budget_period VARCHAR(80) NOT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_zf_budgets_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_expenses (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    project_id INT UNSIGNED NOT NULL,
    budget_id INT UNSIGNED DEFAULT NULL,
    expense_date DATE NOT NULL,
    amount DECIMAL(14,2) NOT NULL DEFAULT 0,
    expense_category VARCHAR(40) NOT NULL,
    linked_module_record VARCHAR(120) DEFAULT NULL,
    approved_by INT UNSIGNED NOT NULL,
    receipt_attached VARCHAR(255) DEFAULT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_zf_expenses_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_donor_funding (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    project_id INT UNSIGNED NOT NULL,
    partner_id INT UNSIGNED NOT NULL,
    amount_committed DECIMAL(14,2) NOT NULL DEFAULT 0,
    amount_received DECIMAL(14,2) DEFAULT NULL,
    agreement_reference VARCHAR(120) DEFAULT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_zf_funding_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_disbursements (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    project_id INT UNSIGNED NOT NULL,
    recipient_type VARCHAR(40) NOT NULL,
    recipient_reference VARCHAR(120) NOT NULL,
    amount DECIMAL(14,2) NOT NULL DEFAULT 0,
    disbursement_date DATE NOT NULL,
    method VARCHAR(40) DEFAULT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_zf_disb_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------------
-- HR
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS zf_staff_assignments (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    staff_id INT UNSIGNED NOT NULL,
    project_id INT UNSIGNED NOT NULL,
    role_on_project VARCHAR(150) NOT NULL,
    allocation_percentage DECIMAL(5,2) DEFAULT NULL,
    start_date DATE DEFAULT NULL,
    end_date DATE DEFAULT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_zf_assign_project (project_id),
    KEY idx_zf_assign_staff (staff_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_recruitments (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    position_title VARCHAR(200) NOT NULL,
    project_id INT UNSIGNED DEFAULT NULL,
    status VARCHAR(40) NOT NULL DEFAULT 'Open',
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_policy_acks (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    staff_id INT UNSIGNED NOT NULL,
    policy_name VARCHAR(200) NOT NULL,
    date_acknowledged DATE NOT NULL,
    signed_document VARCHAR(255) DEFAULT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_zf_policy_staff (staff_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------------
-- Procurement
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS zf_vendors (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    vendor_name VARCHAR(200) NOT NULL,
    country_code CHAR(2) NOT NULL,
    category VARCHAR(60) DEFAULT NULL,
    contact_info VARCHAR(255) DEFAULT NULL,
    vetting_status VARCHAR(40) NOT NULL DEFAULT 'Pending',
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_purchase_requests (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    project_id INT UNSIGNED NOT NULL,
    requested_by INT UNSIGNED NOT NULL,
    items_requested TEXT NOT NULL,
    date_requested DATE NOT NULL,
    approval_status VARCHAR(60) NOT NULL DEFAULT 'Pending',
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_zf_pr_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_purchase_orders (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    pr_id INT UNSIGNED NOT NULL,
    vendor_id INT UNSIGNED NOT NULL,
    total_amount DECIMAL(14,2) NOT NULL DEFAULT 0,
    po_date DATE NOT NULL,
    delivery_status VARCHAR(40) NOT NULL DEFAULT 'Pending',
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_zf_po_pr (pr_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_goods_received (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    po_id INT UNSIGNED NOT NULL,
    received_date DATE NOT NULL,
    received_by INT UNSIGNED NOT NULL,
    condition_notes TEXT,
    linked_distribution_record VARCHAR(120) DEFAULT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_zf_grn_po (po_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------------
-- MEAL + Research
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS zf_indicators (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    project_id INT UNSIGNED NOT NULL,
    indicator_name VARCHAR(255) NOT NULL,
    target_value DECIMAL(14,2) NOT NULL DEFAULT 0,
    achieved_value DECIMAL(14,2) DEFAULT NULL,
    measurement_frequency VARCHAR(20) NOT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_zf_ind_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_monitoring_visits (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    project_id INT UNSIGNED NOT NULL,
    visit_date DATE NOT NULL,
    conducted_by INT UNSIGNED NOT NULL,
    location_id INT UNSIGNED NOT NULL,
    findings_summary TEXT NOT NULL,
    follow_up_actions TEXT,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_zf_mon_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_evaluations (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    project_id INT UNSIGNED NOT NULL,
    evaluation_type VARCHAR(40) NOT NULL,
    conducted_by VARCHAR(200) NOT NULL,
    date_completed DATE NOT NULL,
    report_file VARCHAR(255) DEFAULT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_zf_eval_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_complaints (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    project_id INT UNSIGNED DEFAULT NULL,
    date_received DATE NOT NULL,
    channel VARCHAR(40) NOT NULL,
    category VARCHAR(80) NOT NULL,
    status VARCHAR(40) NOT NULL DEFAULT 'Open',
    confidentiality_flag TINYINT(1) NOT NULL DEFAULT 0,
    details TEXT,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_research_studies (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    related_sector VARCHAR(8) DEFAULT NULL,
    country_code CHAR(2) NOT NULL,
    study_title VARCHAR(255) NOT NULL,
    study_type VARCHAR(60) NOT NULL,
    date_conducted DATE NOT NULL,
    sample_size INT UNSIGNED DEFAULT NULL,
    key_findings_summary TEXT,
    report_file VARCHAR(255) DEFAULT NULL,
    informs_project_id INT UNSIGNED DEFAULT NULL,
    createduserid INT UNSIGNED DEFAULT 0,
    createdtime DATETIME DEFAULT CURRENT_TIMESTAMP,
    updateduserid INT UNSIGNED DEFAULT 0,
    updatedtime DATETIME DEFAULT NULL,
    formhash VARCHAR(64) DEFAULT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS zf_audit_log (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    table_name VARCHAR(80) NOT NULL,
    record_id INT UNSIGNED NOT NULL DEFAULT 0,
    action VARCHAR(20) NOT NULL,
    user_id INT UNSIGNED DEFAULT 0,
    username VARCHAR(50) DEFAULT NULL,
    changed_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    details TEXT,
    PRIMARY KEY (id),
    KEY idx_zf_audit_table (table_name, record_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------------
-- Seed reference data
-- ---------------------------------------------------------------------------
INSERT INTO zf_countries (country_code, country_name, currency, timezone, deleted)
SELECT 'SO', 'Somalia', 'USD', 'EAT', 0 WHERE NOT EXISTS (SELECT 1 FROM zf_countries WHERE country_code = 'SO');
INSERT INTO zf_countries (country_code, country_name, currency, timezone, deleted)
SELECT 'UG', 'Uganda', 'UGX', 'EAT', 0 WHERE NOT EXISTS (SELECT 1 FROM zf_countries WHERE country_code = 'UG');
INSERT INTO zf_countries (country_code, country_name, currency, timezone, deleted)
SELECT 'KE', 'Kenya', 'KES', 'EAT', 0 WHERE NOT EXISTS (SELECT 1 FROM zf_countries WHERE country_code = 'KE');

INSERT INTO zf_sectors (sector_code, sector_name, sector_lead_role, linked_sdgs, deleted)
SELECT 'ORPH', 'Orphan Support', 'Program Coordinator', 'SDG 1, SDG 4', 0 WHERE NOT EXISTS (SELECT 1 FROM zf_sectors WHERE sector_code = 'ORPH');
INSERT INTO zf_sectors (sector_code, sector_name, sector_lead_role, linked_sdgs, deleted)
SELECT 'EDU', 'Education', 'Program Coordinator', 'SDG 4', 0 WHERE NOT EXISTS (SELECT 1 FROM zf_sectors WHERE sector_code = 'EDU');
INSERT INTO zf_sectors (sector_code, sector_name, sector_lead_role, linked_sdgs, deleted)
SELECT 'WASH', 'Water, Sanitation & Hygiene', 'Program Coordinator', 'SDG 6, SDG 3', 0 WHERE NOT EXISTS (SELECT 1 FROM zf_sectors WHERE sector_code = 'WASH');
INSERT INTO zf_sectors (sector_code, sector_name, sector_lead_role, linked_sdgs, deleted)
SELECT 'HLTH', 'Health', 'Program Coordinator', 'SDG 3', 0 WHERE NOT EXISTS (SELECT 1 FROM zf_sectors WHERE sector_code = 'HLTH');
INSERT INTO zf_sectors (sector_code, sector_name, sector_lead_role, linked_sdgs, deleted)
SELECT 'INFR', 'Infrastructure / Community Centres', 'Operations Manager', 'SDG 9, SDG 11', 0 WHERE NOT EXISTS (SELECT 1 FROM zf_sectors WHERE sector_code = 'INFR');
INSERT INTO zf_sectors (sector_code, sector_name, sector_lead_role, linked_sdgs, deleted)
SELECT 'LVHD', 'Livelihoods / Economic Empowerment', 'Program Coordinator', 'SDG 1, SDG 8', 0 WHERE NOT EXISTS (SELECT 1 FROM zf_sectors WHERE sector_code = 'LVHD');
INSERT INTO zf_sectors (sector_code, sector_name, sector_lead_role, linked_sdgs, deleted)
SELECT 'RELF', 'Relief & Kits (Food, Medicine, Dignity, Seasonal)', 'Program Coordinator', 'SDG 2, SDG 3', 0 WHERE NOT EXISTS (SELECT 1 FROM zf_sectors WHERE sector_code = 'RELF');
INSERT INTO zf_sectors (sector_code, sector_name, sector_lead_role, linked_sdgs, deleted)
SELECT 'PEACE', 'Peace & Development / Legal Aid', 'Program Coordinator', 'SDG 16', 0 WHERE NOT EXISTS (SELECT 1 FROM zf_sectors WHERE sector_code = 'PEACE');

INSERT INTO zf_locations (location_code, country_code, region_state, district, gps_coordinates, deleted)
SELECT 'SO-BLD-001', 'SO', 'Hirshabelle State', 'Beletweyne', '4.7361 N, 45.2027 E', 0
WHERE NOT EXISTS (SELECT 1 FROM zf_locations WHERE location_code = 'SO-BLD-001');
INSERT INTO zf_locations (location_code, country_code, region_state, district, deleted)
SELECT 'SO-JOW-003', 'SO', 'Hirshabelle State', 'Jowhar', 0
WHERE NOT EXISTS (SELECT 1 FROM zf_locations WHERE location_code = 'SO-JOW-003');
INSERT INTO zf_locations (location_code, country_code, region_state, district, deleted)
SELECT 'SO-BYD-001', 'SO', 'South West State', 'Baydhaba', 0
WHERE NOT EXISTS (SELECT 1 FROM zf_locations WHERE location_code = 'SO-BYD-001');
INSERT INTO zf_locations (location_code, country_code, region_state, district, deleted)
SELECT 'SO-DNS-001', 'SO', 'South West State', 'Dinsoor', 0
WHERE NOT EXISTS (SELECT 1 FROM zf_locations WHERE location_code = 'SO-DNS-001');
INSERT INTO zf_locations (location_code, country_code, region_state, district, deleted)
SELECT 'UG-KLA-001', 'UG', 'Central', 'Kampala', 0
WHERE NOT EXISTS (SELECT 1 FROM zf_locations WHERE location_code = 'UG-KLA-001');
INSERT INTO zf_locations (location_code, country_code, region_state, district, deleted)
SELECT 'KE-NBO-001', 'KE', 'Nairobi', 'Nairobi', 0
WHERE NOT EXISTS (SELECT 1 FROM zf_locations WHERE location_code = 'KE-NBO-001');

INSERT INTO zf_partners (partner_code, partner_name, partner_type, relationship, country_of_registration, status, notes, deleted)
SELECT 'PTR-001', 'Turkiye Diyanet Vakfi', 'Donor', 'Funding Partner', 'Turkey', 'Active', NULL, 0
WHERE NOT EXISTS (SELECT 1 FROM zf_partners WHERE partner_code = 'PTR-001');
INSERT INTO zf_partners (partner_code, partner_name, partner_type, relationship, country_of_registration, status, notes, deleted)
SELECT 'PTR-002', 'Zakat Foundation of America', 'Donor', 'Funding Partner', 'United States', 'Active', NULL, 0
WHERE NOT EXISTS (SELECT 1 FROM zf_partners WHERE partner_code = 'PTR-002');
INSERT INTO zf_partners (partner_code, partner_name, partner_type, relationship, country_of_registration, status, notes, deleted)
SELECT 'PTR-003', 'Be Aid', 'Donor', 'Funding Partner', NULL, 'Active', NULL, 0
WHERE NOT EXISTS (SELECT 1 FROM zf_partners WHERE partner_code = 'PTR-003');
INSERT INTO zf_partners (partner_code, partner_name, partner_type, relationship, country_of_registration, status, notes, deleted)
SELECT 'PTR-004', 'Humanity for All', 'Donor', 'Funding Partner', NULL, 'Active', NULL, 0
WHERE NOT EXISTS (SELECT 1 FROM zf_partners WHERE partner_code = 'PTR-004');
INSERT INTO zf_partners (partner_code, partner_name, partner_type, relationship, country_of_registration, status, notes, deleted)
SELECT 'PTR-005', 'Kuwait Ministry of Foreign Affairs', 'Accreditation Body', 'Regulatory Accreditation', 'Kuwait', 'Active', 'International Development & Cooperation Affairs accreditation', 0
WHERE NOT EXISTS (SELECT 1 FROM zf_partners WHERE partner_code = 'PTR-005');
INSERT INTO zf_partners (partner_code, partner_name, partner_type, relationship, country_of_registration, status, notes, deleted)
SELECT 'PTR-006', 'NGOSource', 'Accreditation Body', 'Regulatory Accreditation', 'United States', 'Active', 'Equivalent to a U.S. Public Charity', 0
WHERE NOT EXISTS (SELECT 1 FROM zf_partners WHERE partner_code = 'PTR-006');
INSERT INTO zf_partners (partner_code, partner_name, partner_type, relationship, country_of_registration, status, notes, deleted)
SELECT 'PTR-007', 'Uganda National NGO Forum', 'Membership Network', 'Network Membership', 'Uganda', 'Active', NULL, 0
WHERE NOT EXISTS (SELECT 1 FROM zf_partners WHERE partner_code = 'PTR-007');
INSERT INTO zf_partners (partner_code, partner_name, partner_type, relationship, country_of_registration, status, notes, deleted)
SELECT 'PTR-008', 'Uganda Muslim Supreme Council', 'Membership Network', 'Network Membership', 'Uganda', 'Active', NULL, 0
WHERE NOT EXISTS (SELECT 1 FROM zf_partners WHERE partner_code = 'PTR-008');
INSERT INTO zf_partners (partner_code, partner_name, partner_type, relationship, country_of_registration, status, notes, deleted)
SELECT 'PTR-009', 'Union of NGOs of the Islamic World (UNIW)', 'Membership Network', 'Network Membership', 'Turkey', 'Active', 'Istanbul', 0
WHERE NOT EXISTS (SELECT 1 FROM zf_partners WHERE partner_code = 'PTR-009');

INSERT INTO zf_hr_policies (policy_name, deleted)
SELECT 'Financial Management Policy', 0 WHERE NOT EXISTS (SELECT 1 FROM zf_hr_policies WHERE policy_name = 'Financial Management Policy');
INSERT INTO zf_hr_policies (policy_name, deleted)
SELECT 'Procurement Policy', 0 WHERE NOT EXISTS (SELECT 1 FROM zf_hr_policies WHERE policy_name = 'Procurement Policy');
INSERT INTO zf_hr_policies (policy_name, deleted)
SELECT 'Monitoring & Evaluation Policy', 0 WHERE NOT EXISTS (SELECT 1 FROM zf_hr_policies WHERE policy_name = 'Monitoring & Evaluation Policy');
INSERT INTO zf_hr_policies (policy_name, deleted)
SELECT 'Conflict of Interest Policy', 0 WHERE NOT EXISTS (SELECT 1 FROM zf_hr_policies WHERE policy_name = 'Conflict of Interest Policy');
INSERT INTO zf_hr_policies (policy_name, deleted)
SELECT 'Human Resource & Management Policy', 0 WHERE NOT EXISTS (SELECT 1 FROM zf_hr_policies WHERE policy_name = 'Human Resource & Management Policy');
INSERT INTO zf_hr_policies (policy_name, deleted)
SELECT 'Prevention & Protection of Sexual Harassment Policy', 0 WHERE NOT EXISTS (SELECT 1 FROM zf_hr_policies WHERE policy_name = 'Prevention & Protection of Sexual Harassment Policy');
INSERT INTO zf_hr_policies (policy_name, deleted)
SELECT 'Child Protection & Safeguarding Policy', 0 WHERE NOT EXISTS (SELECT 1 FROM zf_hr_policies WHERE policy_name = 'Child Protection & Safeguarding Policy');
INSERT INTO zf_hr_policies (policy_name, deleted)
SELECT 'Anti-Money Laundering & Corruption Policy', 0 WHERE NOT EXISTS (SELECT 1 FROM zf_hr_policies WHERE policy_name = 'Anti-Money Laundering & Corruption Policy');
INSERT INTO zf_hr_policies (policy_name, deleted)
SELECT 'Anti-Terrorism Policy', 0 WHERE NOT EXISTS (SELECT 1 FROM zf_hr_policies WHERE policy_name = 'Anti-Terrorism Policy');
INSERT INTO zf_hr_policies (policy_name, deleted)
SELECT 'Aid Diversion Policy', 0 WHERE NOT EXISTS (SELECT 1 FROM zf_hr_policies WHERE policy_name = 'Aid Diversion Policy');

-- ---------------------------------------------------------------------------
-- Menu
-- ---------------------------------------------------------------------------
INSERT INTO topmenu (id, name, accessname, href, icon, submenu, sort, deleted)
SELECT 3, 'Xogta aasaasiga', 'Master data', 'master', 'icon-notebook', 1, 10, 0
WHERE NOT EXISTS (SELECT 1 FROM topmenu WHERE href = 'master' AND deleted = 0);
INSERT INTO topmenu (id, name, accessname, href, icon, submenu, sort, deleted)
SELECT 4, 'Mashruucyada', 'Projects', 'projects-menu', 'icon-folder', 1, 11, 0
WHERE NOT EXISTS (SELECT 1 FROM topmenu WHERE href = 'projects-menu' AND deleted = 0);
INSERT INTO topmenu (id, name, accessname, href, icon, submenu, sort, deleted)
SELECT 5, 'Agoonta', 'Orphan Support', 'orphans-menu', 'icon-user', 1, 12, 0
WHERE NOT EXISTS (SELECT 1 FROM topmenu WHERE href = 'orphans-menu' AND deleted = 0);
INSERT INTO topmenu (id, name, accessname, href, icon, submenu, sort, deleted)
SELECT 6, 'Waxbarasho', 'Education', 'education-menu', 'icon-book-open', 1, 13, 0
WHERE NOT EXISTS (SELECT 1 FROM topmenu WHERE href = 'education-menu' AND deleted = 0);
INSERT INTO topmenu (id, name, accessname, href, icon, submenu, sort, deleted)
SELECT 7, 'WASH', 'WASH', 'wash-menu', 'icon-drop', 1, 14, 0
WHERE NOT EXISTS (SELECT 1 FROM topmenu WHERE href = 'wash-menu' AND deleted = 0);
INSERT INTO topmenu (id, name, accessname, href, icon, submenu, sort, deleted)
SELECT 8, 'Caafimaad', 'Health', 'health-menu', 'icon-heart', 1, 15, 0
WHERE NOT EXISTS (SELECT 1 FROM topmenu WHERE href = 'health-menu' AND deleted = 0);
INSERT INTO topmenu (id, name, accessname, href, icon, submenu, sort, deleted)
SELECT 9, 'Kaabayaasha', 'Infrastructure', 'infra-menu', 'icon-home', 1, 16, 0
WHERE NOT EXISTS (SELECT 1 FROM topmenu WHERE href = 'infra-menu' AND deleted = 0);
INSERT INTO topmenu (id, name, accessname, href, icon, submenu, sort, deleted)
SELECT 10, 'Nolosha', 'Livelihoods', 'livelihood-menu', 'icon-briefcase', 1, 17, 0
WHERE NOT EXISTS (SELECT 1 FROM topmenu WHERE href = 'livelihood-menu' AND deleted = 0);
INSERT INTO topmenu (id, name, accessname, href, icon, submenu, sort, deleted)
SELECT 11, 'Gargaarka', 'Relief & Kits', 'relief-menu', 'icon-basket', 1, 18, 0
WHERE NOT EXISTS (SELECT 1 FROM topmenu WHERE href = 'relief-menu' AND deleted = 0);
INSERT INTO topmenu (id, name, accessname, href, icon, submenu, sort, deleted)
SELECT 12, 'Nabad & Horumar', 'Peace & Development', 'peace-menu', 'icon-shield', 1, 19, 0
WHERE NOT EXISTS (SELECT 1 FROM topmenu WHERE href = 'peace-menu' AND deleted = 0);
INSERT INTO topmenu (id, name, accessname, href, icon, submenu, sort, deleted)
SELECT 13, 'Maaliyadda', 'Finance', 'finance-menu', 'icon-wallet', 1, 21, 0
WHERE NOT EXISTS (SELECT 1 FROM topmenu WHERE href = 'finance-menu' AND deleted = 0);
INSERT INTO topmenu (id, name, accessname, href, icon, submenu, sort, deleted)
SELECT 14, 'Shaqaalaha', 'Human Resources', 'hr-menu', 'icon-users', 1, 22, 0
WHERE NOT EXISTS (SELECT 1 FROM topmenu WHERE href = 'hr-menu' AND deleted = 0);
INSERT INTO topmenu (id, name, accessname, href, icon, submenu, sort, deleted)
SELECT 15, 'Iibsiga', 'Procurement', 'proc-menu', 'icon-basket-loaded', 1, 23, 0
WHERE NOT EXISTS (SELECT 1 FROM topmenu WHERE href = 'proc-menu' AND deleted = 0);
INSERT INTO topmenu (id, name, accessname, href, icon, submenu, sort, deleted)
SELECT 16, 'MEAL', 'MEAL', 'meal-menu', 'icon-check', 1, 24, 0
WHERE NOT EXISTS (SELECT 1 FROM topmenu WHERE href = 'meal-menu' AND deleted = 0);
INSERT INTO topmenu (id, name, accessname, href, icon, submenu, sort, deleted)
SELECT 17, 'Cilmi-baaris', 'Research', 'research-menu', 'icon-eyeglasses', 1, 25, 0
WHERE NOT EXISTS (SELECT 1 FROM topmenu WHERE href = 'research-menu' AND deleted = 0);
INSERT INTO topmenu (id, name, accessname, href, icon, submenu, sort, deleted)
SELECT 18, 'Warbixin', 'Reports', 'reports-menu', 'icon-bar-chart', 1, 26, 0
WHERE NOT EXISTS (SELECT 1 FROM topmenu WHERE href = 'reports-menu' AND deleted = 0);

INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-globe', 'Waddamada', 'Countries', 'countries', 3, 1, 10, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'countries' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-map-marker', 'Goobaha', 'Locations', 'locations', 3, 1, 20, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'locations' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-th-large', 'Qaybaha', 'Sectors', 'sectors', 3, 1, 30, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'sectors' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-handshake', 'Lammaanayaasha', 'Partners', 'partners', 3, 1, 40, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'partners' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-folder-open', 'Mashruucyada', 'Projects', 'projects', 4, 1, 10, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'projects' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-child', 'Diiwaanka agoonta', 'Orphan registry', 'orphans', 5, 1, 10, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'orphans' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-graduation-cap', 'Waxbarashada agoonta', 'Orphan education', 'orphan-education', 5, 1, 20, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'orphan-education' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-heart', 'Taageerada rubuc-sanadka', 'Quarterly support', 'orphan-support', 5, 1, 30, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'orphan-support' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-user', 'Kafaala-qaadayaasha', 'Sponsors', 'sponsors', 5, 1, 40, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'sponsors' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-truck', 'Qaybinta agabka dugsiga', 'School material distribution', 'school-distributions', 6, 1, 10, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'school-distributions' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-list', 'Agabka qaybinta', 'Education item catalog', 'education-items', 6, 1, 20, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'education-items' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-award', 'Deeq-waxbarasho', 'Scholarships', 'scholarships', 6, 1, 30, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'scholarships' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-tint', 'Goobaha biyaha', 'Water points', 'water-points', 7, 1, 10, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'water-points' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-wrench', 'Dayactirka biyaha', 'Water maintenance', 'water-maintenance', 7, 1, 20, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'water-maintenance' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-hospital', 'Boqashooyinka caafimaadka', 'Health facility visits', 'health-visits', 8, 1, 10, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'health-visits' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-female', 'Hooyada iyo ilmaha', 'Maternal & child health', 'maternal-health', 8, 1, 20, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'maternal-health' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-medkit', 'Xakamaynta cudurrada', 'Disease control', 'disease-control', 8, 1, 30, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'disease-control' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-bullhorn', 'Ololeyaal caafimaad', 'Health education campaigns', 'health-campaigns', 8, 1, 40, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'health-campaigns' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-lock', 'Caafimaadka maskaxda', 'Mental health sessions', 'mental-health', 8, 1, 50, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'mental-health' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-eye', 'Daryeelka indhaha', 'Eye care', 'eye-care', 8, 1, 60, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'eye-care' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-building', 'Hantida kaabayaasha', 'Infrastructure assets', 'infrastructure', 9, 1, 10, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'infrastructure' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-users', 'Tababarro nolosha', 'Livelihood trainings', 'livelihood-trainings', 10, 1, 10, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'livelihood-trainings' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-gift', 'Qaybinta hantida', 'Livelihood assets', 'livelihood-assets', 10, 1, 20, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'livelihood-assets' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-money', 'Deeqaha bilowga', 'Seed capital grants', 'seed-grants', 10, 1, 30, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'seed-grants' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-archive', 'Qaybinta gargaarka', 'Relief distributions', 'relief-distributions', 11, 1, 10, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'relief-distributions' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-balance-scale', 'Kiisaska dhexdhexaadinta', 'Mediation cases', 'mediation-cases', 12, 1, 10, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'mediation-cases' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-comments', 'Wadahadallada', 'Dialogue sessions', 'dialogue-sessions', 12, 1, 20, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'dialogue-sessions' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-gavel', 'Kaalmada sharciga', 'Legal aid cases', 'legal-aid', 12, 1, 30, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'legal-aid' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-calculator', 'Miisaaniyadaha', 'Budgets', 'budgets', 13, 1, 10, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'budgets' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-credit-card', 'Kharashyada', 'Expenses', 'expenses', 13, 1, 20, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'expenses' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-university', 'Maalgelinta deeq-bixiyayaasha', 'Donor funding', 'donor-funding', 13, 1, 30, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'donor-funding' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-exchange', 'Bixinta lacagta', 'Disbursements', 'disbursements', 13, 1, 40, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'disbursements' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-id-badge', 'Shaqaalaha', 'Staff', 'staff', 14, 1, 10, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'staff' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-sitemap', 'Qoondeynta mashruuca', 'Staff assignments', 'staff-assignments', 14, 1, 20, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'staff-assignments' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-briefcase', 'Shaqo-qorista', 'Recruitment', 'recruitments', 14, 1, 30, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'recruitments' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-file-text', 'Oggolaanshaha siyaasadaha', 'Policy acknowledgements', 'policy-acknowledgements', 14, 1, 40, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'policy-acknowledgements' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-truck', 'Iibiyayaasha', 'Vendors', 'vendors', 15, 1, 10, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'vendors' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-file-o', 'Codsiyada iibsiga', 'Purchase requests', 'purchase-requests', 15, 1, 20, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'purchase-requests' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-file-text-o', 'Amarada iibsiga', 'Purchase orders', 'purchase-orders', 15, 1, 30, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'purchase-orders' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-check-square', 'Alaabta la helay', 'Goods received', 'goods-received', 15, 1, 40, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'goods-received' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-line-chart', 'Tilmaamayaasha', 'Indicators', 'indicators', 16, 1, 10, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'indicators' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-map', 'Boqashooyinka kormeerka', 'Monitoring visits', 'monitoring-visits', 16, 1, 20, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'monitoring-visits' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-bar-chart', 'Qiimaynta', 'Evaluations', 'evaluations', 16, 1, 30, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'evaluations' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-commenting', 'Cabashooyinka', 'Complaints & feedback', 'complaints', 16, 1, 40, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'complaints' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-search', 'Daraasado & baaritaan', 'Needs assessments', 'research-studies', 17, 1, 10, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'research-studies' AND deleted = 0);
INSERT INTO pages (fa, pagename, accesspagename, href, topmenuid, sidebar, sort, deleted)
SELECT 'fa-pie-chart', 'Warbixinno', 'Standard reports', 'reports', 18, 1, 10, 0
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE href = 'reports' AND deleted = 0);

UPDATE pages SET fa = 'icon-globe' WHERE href = 'countries' AND deleted = 0;
UPDATE pages SET fa = 'icon-pin' WHERE href = 'locations' AND deleted = 0;
UPDATE pages SET fa = 'icon-layers' WHERE href = 'sectors' AND deleted = 0;
UPDATE pages SET fa = 'icon-users' WHERE href = 'partners' AND deleted = 0;
UPDATE pages SET fa = 'icon-folder-alt' WHERE href = 'projects' AND deleted = 0;
UPDATE pages SET fa = 'icon-user' WHERE href = 'orphans' AND deleted = 0;
UPDATE pages SET fa = 'icon-graduation' WHERE href = 'orphan-education' AND deleted = 0;
UPDATE pages SET fa = 'icon-heart' WHERE href = 'orphan-support' AND deleted = 0;
UPDATE pages SET fa = 'icon-like' WHERE href = 'sponsors' AND deleted = 0;
UPDATE pages SET fa = 'icon-basket-loaded' WHERE href = 'school-distributions' AND deleted = 0;
UPDATE pages SET fa = 'icon-list' WHERE href = 'education-items' AND deleted = 0;
UPDATE pages SET fa = 'icon-trophy' WHERE href = 'scholarships' AND deleted = 0;
UPDATE pages SET fa = 'icon-drop' WHERE href = 'water-points' AND deleted = 0;
UPDATE pages SET fa = 'icon-wrench' WHERE href = 'water-maintenance' AND deleted = 0;
UPDATE pages SET fa = 'icon-home' WHERE href = 'health-visits' AND deleted = 0;
UPDATE pages SET fa = 'icon-symbol-female' WHERE href = 'maternal-health' AND deleted = 0;
UPDATE pages SET fa = 'icon-shield' WHERE href = 'disease-control' AND deleted = 0;
UPDATE pages SET fa = 'icon-speech' WHERE href = 'health-campaigns' AND deleted = 0;
UPDATE pages SET fa = 'icon-emoticon-smile' WHERE href = 'mental-health' AND deleted = 0;
UPDATE pages SET fa = 'icon-eye' WHERE href = 'eye-care' AND deleted = 0;
UPDATE pages SET fa = 'icon-drawer' WHERE href = 'infrastructure' AND deleted = 0;
UPDATE pages SET fa = 'icon-users' WHERE href = 'livelihood-trainings' AND deleted = 0;
UPDATE pages SET fa = 'icon-present' WHERE href = 'livelihood-assets' AND deleted = 0;
UPDATE pages SET fa = 'icon-wallet' WHERE href = 'seed-grants' AND deleted = 0;
UPDATE pages SET fa = 'icon-basket' WHERE href = 'relief-distributions' AND deleted = 0;
UPDATE pages SET fa = 'icon-equalizer' WHERE href = 'mediation-cases' AND deleted = 0;
UPDATE pages SET fa = 'icon-bubble' WHERE href = 'dialogue-sessions' AND deleted = 0;
UPDATE pages SET fa = 'icon-book-open' WHERE href = 'legal-aid' AND deleted = 0;
UPDATE pages SET fa = 'icon-calculator' WHERE href = 'budgets' AND deleted = 0;
UPDATE pages SET fa = 'icon-credit-card' WHERE href = 'expenses' AND deleted = 0;
UPDATE pages SET fa = 'icon-diamond' WHERE href = 'donor-funding' AND deleted = 0;
UPDATE pages SET fa = 'icon-share' WHERE href = 'disbursements' AND deleted = 0;
UPDATE pages SET fa = 'icon-badge' WHERE href = 'staff' AND deleted = 0;
UPDATE pages SET fa = 'icon-user-following' WHERE href = 'staff-assignments' AND deleted = 0;
UPDATE pages SET fa = 'icon-briefcase' WHERE href = 'recruitments' AND deleted = 0;
UPDATE pages SET fa = 'icon-docs' WHERE href = 'policy-acknowledgements' AND deleted = 0;
UPDATE pages SET fa = 'icon-handbag' WHERE href = 'vendors' AND deleted = 0;
UPDATE pages SET fa = 'icon-note' WHERE href = 'purchase-requests' AND deleted = 0;
UPDATE pages SET fa = 'icon-doc' WHERE href = 'purchase-orders' AND deleted = 0;
UPDATE pages SET fa = 'icon-check' WHERE href = 'goods-received' AND deleted = 0;
UPDATE pages SET fa = 'icon-graph' WHERE href = 'indicators' AND deleted = 0;
UPDATE pages SET fa = 'icon-map' WHERE href = 'monitoring-visits' AND deleted = 0;
UPDATE pages SET fa = 'icon-bar-chart' WHERE href = 'evaluations' AND deleted = 0;
UPDATE pages SET fa = 'icon-bubbles' WHERE href = 'complaints' AND deleted = 0;
UPDATE pages SET fa = 'icon-eyeglasses' WHERE href = 'research-studies' AND deleted = 0;
UPDATE pages SET fa = 'icon-pie-chart' WHERE href = 'reports' AND deleted = 0;

INSERT INTO pagepermissions (roleid, pageid, permissionid, view, edit, del, code, deleted)
SELECT 2, p.id, 1, 1, 0, 0, CONCAT('2-', p.id), 0
FROM pages p
WHERE p.deleted = 0
  AND NOT EXISTS (
      SELECT 1 FROM pagepermissions pp
      WHERE pp.deleted = 0 AND pp.roleid = 2 AND pp.pageid = p.id
  );
