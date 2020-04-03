select psnt.id_ind_psn ,
(psn.uraian ) as uraian,
psnt.tahun ,
 psnt.target as target_pusat,
(
case when (psn.cal_type)='min_accept' 
then
(
	select  count(tgd.*) from ind_psn_target_pro as tgd  where tgd.target >= psnt.target and tgd.tahun=psnt.tahun and tgd.id_ind_psn=psnt.id_ind_psn group by tgd.id_ind_psn limit 1
)
when 
(psn.cal_type)='max_accept' 
then 
(
	select  count(tgd.*) from ind_psn_target_pro as tgd  where tgd.target <= psnt.target and tgd.tahun=psnt.tahun and tgd.id_ind_psn=psnt.id_ind_psn group by tgd.id_ind_psn limit 1
)
when 
(psn.cal_type)='aggregate'
then
(
	select  sum(tgd.target::numeric) from ind_psn_target_pro as tgd  where  tgd.tahun=psnt.tahun and tgd.id_ind_psn=psnt.id_ind_psn group by tgd.id_ind_psn limit 1
)
when 
(psn.cal_type)='aggregate_min'
then 
(
	select  sum(-1*(tgd.target::numeric)) from ind_psn_target_pro as tgd  where  tgd.tahun=psnt.tahun and tgd.id_ind_psn=psnt.id_ind_psn group by tgd.id_ind_psn limit 1
)
else
0
end 
) as terpenuhi,
case when (psn.cal_type in ('min_accept','max_accept')) then 'acceptable'
when (psn.cal_type in ('aggregate','aggregate_min'))
then 'cal'
else 
'none'
end as type,
(
case when (psn.cal_type)='min_accept' 
then
(
	select  CONCAT('(',STRING_AGG(tgd.kode_daerah,','),')') from ind_psn_target_pro as tgd  where tgd.target >= psnt.target and tgd.tahun=psnt.tahun and tgd.id_ind_psn=psnt.id_ind_psn group by tgd.id_ind_psn limit 1
)
when 
(psn.cal_type)='max_accept' 
then 
(
	select CONCAT('(',STRING_AGG(tgd.kode_daerah,','),')') from ind_psn_target_pro as tgd  where tgd.target <= psnt.target and tgd.tahun=psnt.tahun and tgd.id_ind_psn=psnt.id_ind_psn group by tgd.id_ind_psn limit 1
)
when 
(psn.cal_type)='aggregate'
then
(
	select  CONCAT('(',STRING_AGG(tgd.kode_daerah,','),')') from ind_psn_target_pro as tgd  where  tgd.tahun=psnt.tahun and tgd.id_ind_psn=psnt.id_ind_psn group by tgd.id_ind_psn limit 1
)
when 
(psn.cal_type)='aggregate_min'
then 
(
	select  CONCAT('(',STRING_AGG(tgd.kode_daerah,','),')') from ind_psn_target_pro as tgd  where  tgd.tahun=psnt.tahun and tgd.id_ind_psn=psnt.id_ind_psn group by tgd.id_ind_psn limit 1
)
else
'()'
end 
) as daerah
from ind_psn_target as psnt
join ind_psn as psn on psn.id=psnt.id_ind_psn and psn.cal_type in ('min_accept','max_accept','aggregate','aggregate_min')
--group by psnt.id_ind_psn 