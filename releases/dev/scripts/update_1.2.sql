ALTER TABLE student_answer
  ADD created_at DATETIME NULL DEFAULT NULL AFTER assessment;

TRUNCATE TABLE migration_version;
INSERT INTO migration_version (version) VALUES (21);
