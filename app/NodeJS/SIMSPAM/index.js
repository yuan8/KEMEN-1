// var Nightmare = require('nightmare')   
var id=540;
const querystring = require('querystring');
var request = require('request');

const { Client } = require('pg');
const { readFileSync, writeFileSync } = require('fs');
const fs = require('fs');


// config db pertama
const env=require('dotenv').config({path: '../../../.env'})

// kl mau untuk local activkan kedua tutup pertama

// config db kedua
// const env=require('dotenv').config({path: './.env'})

const client = new Client({
  host: env.parsed.DB_HOST,
  port: env.parsed.DB_PORT,
  user: env.parsed.DB_USERNAME,
  password:env.parsed.DB_PASSWORD,
  database:"production_nuwas",
  query_timeout:1000000,
  statement_timeout:1000000
});

var knex = require('knex')({
  client: 'pg',
  connection: {
    host: env.parsed.DB_HOST,
    port: env.parsed.DB_PORT,
    user: env.parsed.DB_USERNAME,
    password:env.parsed.DB_PASSWORD,
    database:"production_nuwas",

  },
 
  acquireConnectionTimeout: 10000000
});


client
  .connect()
  .then(() => console.log("\x1b[37m",'connected'))
  .catch(err => console.error('connection error', err.stack));

async function initDb(){


  var sql = await fs.readFileSync('./storage/template_table.sql').toString();
  console.log("\x1b[37m",' try connection db ');
 setTimeout(function(){
    client.query(sql, function(err, result){
      if(err){
          console.log("\x1b[37m",'error: ', err);
          process.exit(1);
      }else{
         console.log("\x1b[37m",'-- init table db success --');
      }
      // console.log(result);
    });
  },300);

}

initDb();

const puppeteer = require('puppeteer');
// var nightmare = Nightmare({ show: true })

var prov = readFileSync('./storage/master_daerah.json');
prov=JSON.parse(prov);
const page={};
// const browser={};
// dd_user='k8373646';

async function login() {
  try{
    console.log("\x1b[37m",'--- mencoba untuk atemp login ----');
    const browser =  await puppeteer.launch({headless: true});
    const page = await browser.newPage();
    await page.setDefaultNavigationTimeout(9900000);
    await page.goto('http://localhost/dss/bot/simspam-login',{ waitUntil: 'networkidle0' });
    // await page.goto('http://airminum.ciptakarya.pu.go.id/sinkronisasi/login.php?appid=spam',{ waitUntil: 'networkidle0' });
    
    await page.type('#username','admin');
    await page.type('#password','spam3257');
    await Promise.all([
          page.click('button[type="submit"]'),
          // page.waitForNavigation({ waitUntil: 'networkidle0' }),
    ]);

    console.log("\x1b[37m",'-- percobaan login selesai, sistem dapat memasuki website ---');
    console.log("\x1b[37m",'mencoba mengambil data perpipaan ....');
    goDetail(page,id);
    return browser;
  }catch(e){
    throw e;
    browser.close();
    // await page.click('button[type="submit"]');
  }
}

function key(name){
    return name.replace(/ /g,'_');
}

async function goDetail(page,k=null){
  try{
	if(k!=null){
		id=k;
	}
  console.log("\x1b[37m",'running '+id+' ...');
  console.log("\x1b[36m",prov[id].nama);
    var daerah=prov[id];
     await page.goto('http://airminum.ciptakarya.pu.go.id/sinkronisasi/rosimspamdataunitlist.php?id='+prov[id].id,{ waitUntil: 'networkidle0' });
     const result = await page.evaluate((daerah)=>{
              return new Promise((resove,reject)=>{
                 var rekap={};

                    $('#Rekap table tbody tr').each(function(k,d)
                    {

                       if($(d).find('td:nth-child(1)').text().toUpperCase().trim()!='TOTAL'){
                            rekap[daerah.id+'_'+($(d).find('td:nth-child(1)').text()).trim().replace(/ /g,'_').toUpperCase()]=({
                                key:daerah.id+'_'+($(d).find('td:nth-child(1)').text()).trim().replace(/ /g,'_').toUpperCase(),
                                nama:$(d).find('td:nth-child(1)').text(),
                                kode_daerah:daerah.id_permendagri,
                                kode_daerah_simspam:daerah.id,
                                kapasitas_terpasang_l_per_detik:parseFloat($(d).find('td:nth-child(2)').text().replace(/,/g,'')),
                                kapasitas_produksi_l_per_detik:parseFloat($(d).find('td:nth-child(3)').text().replace(/,/g,'')),
                                kapasitas_distribusi_l_per_detik:parseFloat($(d).find('td:nth-child(4)').text().replace(/,/g,'')),
                                kapasitas_air_terjual_l_per_detik:parseFloat($(d).find('td:nth-child(5)').text().replace(/,/g,'')),
                                kapasitas_belum_terpakai_l_per_detik:parseFloat($(d).find('td:nth-child(6)').text().replace(/,/g,'')),
                                kehilangan_air_persen:parseFloat($(d).find('td:nth-child(7)').text().replace(/,/g,'')),
                                sambungan_rumah_unit:parseFloat($(d).find('td:nth-child(8)').text().replace(/,/g,'')),
                                updated_at:$(d).find('td:nth-child(9)').text()!=''?($(d).find('td:nth-child(9)').text().replace(/-/g,'/')):'2009/01/01',
                                rimayat_sr:{}
                            });
                       }
                    
                    });

                     $('#DataUmum table tbody tr').each(function(k,d)
                       {
                       var key=daerah.id+'_'+($(d).find('td:nth-child(1)').text()).trim().replace(/ /g,'_').toUpperCase();
                       if($(d).find('td:nth-child(1)').text().toUpperCase().trim()!='TOTAL')
                       {
                            rekap[key]['kat_pelayanan']=$(d).find('td:nth-child(2)').text().trim().toUpperCase()=='YA'?'KOTA':null;
                            if(rekap[key].kat_pelayanan==null){
                                rekap[key]['kat_pelayanan']=$(d).find('td:nth-child(3)').text().trim().toUpperCase()=='YA'?'DESA':null;
                            }else{

                            }
                            
                            switch('YA'){
                                case $(d).find('td:nth-child(4)').text().toUpperCase().trim():
                                rekap[key]['kat_pengelolaan']='BLU';
                                break;
                                case $(d).find('td:nth-child(5)').text().toUpperCase().trim():
                                rekap[key]['kat_pengelolaan']='SWASTA';
                                break;
                                case $(d).find('td:nth-child(6)').text().toUpperCase().trim():
                                rekap[key]['kat_pengelolaan']='PDAM';
                                break;
                                case $(d).find('td:nth-child(7)').text().toUpperCase().trim():
                                rekap[key]['kat_pengelolaan']='UPT';
                                break;
                                case $(d).find('td:nth-child(8)').text().toUpperCase().trim():
                                rekap[key]['kat_pengelolaan']='POKMAS';
                                break;
                                default:
                                rekap[key]['kat_pengelolaan']=null;
                                break;
                            }

                       }
                    
                    });

                    var tahun_last=parseInt($('#DataPelayanan table thead tr:nth-child(2) td:last-child').text().trim());

                    $('#DataPelayanan table tbody tr').each(function(k,d)
                       {
                       var key=daerah.id+'_'+($(d).find('td:nth-child(1)').text()).trim().replace(/ /g,'_').toUpperCase();
                       if($(d).find('td:nth-child(1)').text().toUpperCase().trim()!='TOTAL')
                       {
                           rekap[key]['hidran_umum_unit']=parseFloat($(d).find('td:nth-child(2)').text().replace(/,/g,''));
                           rekap[key]['sambungan_komersial_non_domestik']=parseFloat($(d).find('td:nth-child(3)').text().replace(/,/g,''));
                           rekap[key]['penduduk_terlayani_jiwa']=parseFloat($(d).find('td:nth-child(4)').text().replace(/,/g,''));
                           rekap[key]['persentase_pelayanan_persen']=parseFloat($(d).find('td:nth-child(5)').text().replace(/,/g,''));
                           var index_tahun=6;
                           for(var tahun=tahun_last-8;tahun<=tahun_last;tahun++){
                               rekap[key].rimayat_sr[tahun]=parseFloat($(d).find('td:nth-child('+index_tahun+')').text().replace(/,/g,''))
                               index_tahun++;
                           }
                       }
                    });

                     $('#DataTeknis table tbody tr ').each(function(k,d)
                       {
                       var key=daerah.id+'_'+($(d).find('td:nth-child(1)').text()).trim().replace(/ /g,'_').toUpperCase();
                       if($(d).find('td:nth-child(1)').text().toUpperCase().trim()!='TOTAL')
                       {
                           rekap[key]['total_jam_oprasional_perhari']=parseFloat($(d).find('td:last-child()').text().replace(/,/g,''));
                          
                       }
                    });


                     $('#TargetPelayanan table tbody tr ').each(function(k,d)
                       {
                       var key=daerah.id+'_'+($(d).find('td:nth-child(1)').text()).trim().replace(/ /g,'_').toUpperCase();
                       if($(d).find('td:nth-child(1)').text().toUpperCase().trim()!='TOTAL')
                       {
                           rekap[key]['target_sambungan_rumah_unit']=parseFloat($(d).find('td:nth-child(2)').text().replace(/,/g,''));
                           rekap[key]['target_penduduk_terlayani_jiwa']=parseFloat($(d).find('td:nth-child(3)').text().replace(/,/g,''));
                           rekap[key]['target_cakupan_layanan_persen']=parseFloat($(d).find('td:nth-child(4)').text().replace(/,/g,''));


                          
                       }
                    });

                     $('#RencanaPengembangan table tbody tr ').each(function(k,d)
                       {
                       var key=daerah.id+'_'+($(d).find('td:nth-child(1)').text()).trim().replace(/ /g,'_').toUpperCase();
                       if($(d).find('td:nth-child(1)').text().toUpperCase().trim()!='TOTAL')
                       {
                           rekap[key]['idle_capacity_yang_dimanfaatkan_l_per_detik']=parseFloat($(d).find('td:nth-child(2)').text().replace(/,/g,''));
                           rekap[key]['rencana_penambahan_capacity_uprating_l_per_detaik']=parseFloat($(d).find('td:nth-child(3)').text().replace(/,/g,''));
                           rekap[key]['rencana_penambahan_capacity_pembangunan_unit_baru_l_per_detaik']=parseFloat($(d).find('td:nth-child(4)').text().replace(/,/g,''));
                           rekap[key]['rencana_kebutuhan_capacity_air_baku_l_per_detik']=parseFloat($(d).find('td:nth-child(5)').text().replace(/,/g,''));
                           rekap[key]['rencana_kebutuhan_capacity_intek_l_per_detik']=parseFloat($(d).find('td:nth-child(6)').text().replace(/,/g,''));
                           rekap[key]['kapasita_sumber_air_baku_l_per_detik']=parseFloat($(d).find('td:nth-child(7)').text().replace(/,/g,''));
                           rekap[key]['alokasi_kapasitas_air_baku_sesuai_sipa_l_per_detaik']=parseFloat($(d).find('td:nth-child(8)').text().replace(/,/g,''));
                           rekap[key]['kapasitas_intake_air_baku_l_per_detaik']=parseFloat($(d).find('td:nth-child(9)').text().replace(/,/g,''));
                           

                       }
                    });

                     $('#Catatan table tbody tr ').each(function(k,d)
                       {
                       var key=daerah.id+'_'+($(d).find('td:nth-child(1)').text()).trim().replace(/ /g,'_').toUpperCase();
                       if($(d).find('td:nth-child(1)').text().toUpperCase().trim()!='TOTAL')
                       {
                           rekap[key]['catatan']=($(d).find('td:nth-child(2)').text().trim())!=''?($(d).find('td:nth-child(2)').text().trim()):null;
                         
                       }
                    });

                   setTimeout(function(){
                       resove(rekap);
                   },1000);
              });

     },daerah);
     console.log(id);
     console.log("\x1b[37m",'----------------');
     
     saveDb(result);





     fs.writeFileSync('./storage/data_perpipaan/'+prov[id].id+'.json',JSON.stringify(result,undefined,4));
     if(prov[id+1]!=undefined){
         setTimeout(function(){
             goDetail(page,(id+1));
         },1000);
     }else{

         console.log("\x1b[37m",'data selesai ter update');
         notif();
         process.exit(0);
         // await browser.close();
     }

   }catch(e){
     throw e;

     process.exit(0);
   }


	
}


setTimeout(function(){
 const browser=login();
},2000);


async function saveDb(result){
   for(var dex in result ){

       console.log("\x1b[37m",result[dex].nama);

        const a= await knex.from('simspam.perpipaan').select('*').where({
          'key':result[dex].key,
          'kode_daerah_simspam':result[dex].kode_daerah_simspam
        }).then(function(rows){
           if(rows.length > 0 ){
              console.log("\x1b[32m",'masuk update '+dex);
               knex('simspam.perpipaan').update(result[dex]).where({
                'key':result[dex].key,
                'kode_daerah_simspam':result[dex].kode_daerah_simspam
              }).then(function(rows){
                return rows;
              });

            }else{
              console.log("\x1b[34m",'masuk insert '+dex);
            knex('simspam.perpipaan').insert(result[dex]).then(function(rows){
              return rows;
            });
            }


        });
       
     }

}

console.log("\x1b[37m",'------- Loading -------');

const options_notif = {
  url: 'https://hooks.slack.com/services/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',
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
  },
  form:querystring.stringify({'text':'SIMSPAM - PERPIPAAN TELAH TERUPDATE '})
};


function callback(error, response, body) {
    if (!error && response.statusCode == 200) {
        console.log(body);
    }else{
      console.log('errorroooo');
      console.log(body);
      console.log(error);
    }
}


async function notif(){
 const a=await (request(options_notif, callback));
 // console.log(a);
}

