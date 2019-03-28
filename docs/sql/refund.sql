-- DROP TABLE TRX_TIKET_REFUND;
CREATE TABLE TRX_TIKET_REFUND
(
	[ID_TRX_TIKET_REFUND] INT IDENTITY(1,1) NOT NULL,
	[KODE_REFUND] NVARCHAR(10) NOT NULL,
	[ID_TRX_TIKET_SALES] INT,
	[ID_STATUS_PESAN] INT,
	[ID_PENGGUNA] INT,
	[TGL_PENGAJUAN] DATE,
	[WAKTU_PENGAJUAN] TIME,
	[NAMA_PEMOHON] NVARCHAR(255),
	[ID_JENIS_IDENTITAS] INT,
	[NOMOR_IDENTITAS] NVARCHAR(255),
	[BUKTI_IDENTITAS] NVARCHAR(255),
	[NOMOR_TELP] NVARCHAR(255),
	[EMAIL] NVARCHAR(255),
	[ID_BANK] INT,
	[REKENING] NVARCHAR(255),
	[ATAS_NAMA] NVARCHAR(255),
	[TGL_PROSES] DATE,
	[WAKTU_PROSES] TIME,
	[ALASAN] NVARCHAR(255),
	PRIMARY KEY NONCLUSTERED (ID_TRX_TIKET_REFUND),
	UNIQUE(KODE_REFUND)
) WITH (MEMORY_OPTIMIZED=ON);

ALTER TABLE TRX_TIKET_REFUND ADD CONSTRAINT FK_TIKET_REFUND FOREIGN KEY(ID_TRX_TIKET_SALES) REFERENCES TRX_TIKET_SALES(ID_TRX_TIKET_SALES);
ALTER TABLE TRX_TIKET_REFUND ADD CONSTRAINT FK_TIKET_REFUND_STATUS_PESAN FOREIGN KEY(ID_STATUS_PESAN) REFERENCES REF_STATUS_PESAN(ID_STATUS_PESAN);
ALTER TABLE TRX_TIKET_REFUND ADD CONSTRAINT FK_TIKET_REFUND_PENGGUNA FOREIGN KEY(ID_PENGGUNA) REFERENCES ACC_PENGGUNA(ID_PENGGUNA);
ALTER TABLE TRX_TIKET_REFUND ADD CONSTRAINT FK_TIKET_REFUNDJENIS_IDENTITAS FOREIGN KEY(ID_JENIS_IDENTITAS) REFERENCES REF_JENIS_IDENTITAS(ID_JENIS_IDENTITAS);
	
-- CREATE INDEX TRX_TIKET_REFUND_TGL_PENGAJUAN ON TRX_TIKET_REFUND(TGL_PENGAJUAN);
-- CREATE INDEX TRX_TIKET_REFUND_TGL_PROSES ON TRX_TIKET_REFUND(TGL_PROSES);

-- DROP TABLE TRX_TIKET_REFUND_DETAIL;
CREATE TABLE TRX_TIKET_REFUND_DETAIL
(
	[ID_TIKET_REFUND_DETAIL] INT IDENTITY(1,1) NOT NULL,
	[ID_TRX_TIKET_SALES_DETAIL] INT NOT NULL,
	[ID_TRX_TIKET_REFUND] INT,
	[ID_STATUS_REFUND] INT,
	[REFUND] INT DEFAULT 0,
	[CATATAN] NVARCHAR(255),
	PRIMARY KEY NONCLUSTERED (ID_TIKET_REFUND_DETAIL)
) WITH (MEMORY_OPTIMIZED=ON);

ALTER TABLE TRX_TIKET_REFUND_DETAIL ADD CONSTRAINT FK_TRX_TIKET_SALES_DETAIL FOREIGN KEY(ID_TRX_TIKET_SALES_DETAIL) REFERENCES TRX_TIKET_SALES_DETAIL(ID_TRX_TIKET_SALES_DETAIL);
ALTER TABLE TRX_TIKET_REFUND_DETAIL ADD CONSTRAINT FK_TRX_TIKET_REFUND FOREIGN KEY(ID_TRX_TIKET_REFUND) REFERENCES TRX_TIKET_REFUND(ID_TRX_TIKET_REFUND);
ALTER TABLE TRX_TIKET_REFUND_DETAIL ADD CONSTRAINT FK_TRX_TIKET_STATUS_REFUND FOREIGN KEY(ID_STATUS_REFUND) REFERENCES REF_STATUS_REFUND(ID_STATUS_REFUND);