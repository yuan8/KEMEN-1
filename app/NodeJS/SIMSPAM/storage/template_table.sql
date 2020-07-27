

CREATE TABLE IF NOT EXISTS simspam.perpipaan (
	id bigserial NOT NULL,
	key varchar(225) NOT NULL,
	kode_daerah varchar(4) NULL,
	kode_daerah_simspam varchar(4) NULL,
	nama varchar(225) NOT NULL,
	kapasitas_terpasang_l_per_detik float8 NULL,
	kapasitas_produksi_l_per_detik float8 NULL,
	kapasitas_distribusi_l_per_detik float8 NULL,
	kapasitas_air_terjual_l_per_detik float8 NULL,
	kapasitas_belum_terpakai_l_per_detik float8 NULL,
	kehilangan_air_persen float8 NULL,
	sambungan_rumah_unit float8 NULL,
	kat_pelayanan varchar(225) NULL,
	kat_pengelolaan varchar(225) NULL,
	hidran_umum_unit float8 NULL,
	sambungan_komersial_non_domestik float8 NULL,
	penduduk_terlayani_jiwa float8 NULL,
	persentase_pelayanan_persen float8 NULL,
	total_jam_oprasional_perhari float8 NULL,
	target_sambungan_rumah_unit float8 NULL,
	target_penduduk_terlayani_jiwa float8 NULL,
	target_cakupan_layanan_persen float8 NULL,
	idle_capacity_yang_dimanfaatkan_l_per_detik float8 NULL,
	rencana_penambahan_capacity_uprating_l_per_detaik float8 NULL,
	rencana_penambahan_capacity_pembangunan_unit_baru_l_per_detaik float8 NULL,
	rencana_kebutuhan_capacity_air_baku_l_per_detik float8 NULL,
	rencana_kebutuhan_capacity_intek_l_per_detik float8 NULL,
	kapasita_sumber_air_baku_l_per_detik float8 NULL,
	alokasi_kapasitas_air_baku_sesuai_sipa_l_per_detaik float8 NULL,
	kapasitas_intake_air_baku_l_per_detaik float8 NULL,
	catatan text null,
	rimayat_sr text null,
	created_at timestamp NULL,
	updated_at timestamp NULL,

	CONSTRAINT perpipaan_pkey PRIMARY KEY (id),
	CONSTRAINT perpipaan_key_kode_daerah_simspam_unique UNIQUE (key, kode_daerah_simspam),
	CONSTRAINT perpipaan_kode_daerah_simspam_foreign FOREIGN KEY (kode_daerah_simspam) REFERENCES simspam.master_daerah_simspam(id) ON UPDATE CASCADE ON DELETE CASCADE

);

CREATE TABLE IF NOT EXISTS simspam.non_perpipaan (
	id bigserial NOT NULL,
	kode_daerah varchar(4) NULL,
	kode_daerah_simspam varchar(4) NULL,
	bjp_sumur_bor_at_pompa float8 NULL,
	bjp_sumur_terlindungi float8 NULL,
	bjp_mata_air_telindungi float8 NULL,
	bjp_air_hujan float8 NULL,
	jumlah_rumah_tangga float8 NULL,
	
	created_at timestamp NULL,
	updated_at timestamp NULL,

	CONSTRAINT non_perpipaan_pkey PRIMARY KEY (id),
	CONSTRAINT non_perpipaan_kode_daerah_simspam_unique UNIQUE (kode_daerah_simspam),
	CONSTRAINT non_perpipaan_kode_daerah_simspam_foreign FOREIGN KEY (kode_daerah_simspam) REFERENCES simspam.master_daerah_simspam(id) ON UPDATE CASCADE ON DELETE CASCADE

);

-- CREATE INDEX master_s_daerah_kode_daerah_parent_index ON simspam.master_daerah_simspam USING btree (kode_daerah_parent);
-- CREATE INDEX master_s_daerah_nama_index ON simspam.master_daerah_simspam USING btree (nama);