CREATE TABLE ACC_KEYS
(
	[id] INT IDENTITY(1,1) NOT NULL,
	[user_id] INT NOT NULL,
	[key] NVARCHAR(40) NOT NULL,
	[level] INT NOT NULL,
	[ignore_limits] TINYINT NOT NULL DEFAULT 0,
	[is_private_key] TINYINT NOT NULL DEFAULT 0,
	[ip_addresses] NVARCHAR(20) NULL DEFAULT NULL,
	[date_created] INT NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY(user_id) REFERENCES ACC_PENGGUNA(ID_PENGGUNA) ON UPDATE CASCADE ON DELETE CASCADE
);