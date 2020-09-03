update public.ikb_uu set uraian=upper(uraian);

update public.ikb_pp set uraian=upper(uraian);

update public.ikb_perpres set uraian=upper(uraian);
update public.ikb_permen set uraian=upper(uraian);
update public.ikb_perda set uraian=upper(uraian);
update public.ikb_perkada set uraian=upper(uraian);
update public.ikb_lainnya set uraian=upper(uraian);
update public.ikb_mandat set uraian=upper(uraian);


update form.kb5_arah_kebijakan set uraian=upper(uraian);
update form.kb5_isu_strategis set uraian=upper(uraian);
update form.kb5_kondisi_saat_ini set uraian=upper(uraian);

update rkp.master_rkp set uraian=upper(uraian);
update form.master_indikator set uraian=upper(uraian);

update form.master_kewenangan set kewenangan_k =upper(kewenangan_k ), kewenangan_nas =upper(kewenangan_nas ) kewenangan_p =upper(kewenangan_p ) ;

update public.ms_akar set uraian =upper(uraian);

update public.ms_pokok set uraian =upper(uraian);
update public.ms set uraian =upper(uraian);
update public.ms_data_dukung set uraian =upper(uraian);


