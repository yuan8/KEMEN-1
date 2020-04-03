 const puppeteer = require('puppeteer');
// var nightmare = Nightmare({ show: true })
const { readFileSync, writeFileSync } = require('fs');
const fs = require('fs');
const env=require('dotenv').config({path: '../../../.env'})

var prov = readFileSync('./storage/master_daerah/id_provinsi.json');
prov=JSON.parse(prov);

var daerahKota = readFileSync('./storage/kota_by_nama.json');
daerah=JSON.parse(daerahKota);
var id=0;
const page={};

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
    console.log("\x1b[37m",'mencoba mengambil data non perpipaan ....');
    goDetail(page,id);
    return browser;
  }catch(e){
    throw e;
    browser.close();
    // await page.click('button[type="submit"]');
  }
}



async function goDetail(page,k=null){

    if(k!=null){
        id=k;
    }
  console.log('-- trying get data '+id+'--');

     await page.goto('http://airminum.ciptakarya.pu.go.id/sinkronisasi/simspambjpdataproplist.php?id='+prov[id].id,{ waitUntil: 'networkidle0' });
     const result = await page.evaluate((daerah)=>{
              return new Promise((resove,reject)=>{
                 var rekap={};


                 

                     $('table#simple-table tbody tr ').each(function(k,d)
                       {
                       var key=($(d).find('td:nth-child(1)').text()).replace(/ /g,'_').toUpperCase();
                       if($(d).find('td:nth-child(1)').text().toUpperCase().trim()!='TOTAL')
                       {
                           rekap[key]={};
                           rekap[key]['bjp_sumur_bor_at_pompa']=parseFloat($(d).find('td:nth-child(2)').text().trim().replace(/,/g,''));
                           rekap[key]['bjp_sumur_terlindungi']=parseFloat($(d).find('td:nth-child(3)').text().trim().replace(/,/g,''));
                           rekap[key]['bjp_mata_air_telindungi']=parseFloat($(d).find('td:nth-child(4)').text().trim().replace(/,/g,''));
                           rekap[key]['bjp_air_hujan']=parseFloat($(d).find('td:nth-child(5)').text().trim().replace(/,/g,''));
                           rekap[key]['jumlah_rumah_tangga']=parseFloat($(d).find('td:nth-child(6)').text().trim().replace(/,/g,''));
                           rekap[key]['kode_daerah']=daerah[key].id_permendagri;
                           rekap[key]['kode_daerah_simspam']=daerah[key].id;
                           // rekap[key]['nama']=$(d).find('td:nth-child(1)').text().toUpperCase().trim();

                       }
                    });

                   setTimeout(function(){
                       resove(rekap);
                   },1000);
              });

     },daerah);
     console.log(id);
     console.log('----------------');

     fs.writeFileSync('./storage/data_non_perpipaan/'+prov[id].id+'.json',JSON.stringify(result,undefined,4));
     
     storeDb(result);


     if(prov[id+1]!=undefined){
         setTimeout(function(){
             goDetail(page,(id+1));
         },1000);
     }else{
         console.log('data selesai ter update');
     }


}

setTimeout(function(){
 login();
},2000);
console.log('------- Loading -------');

async function storeDb(result){
    for(var dex in result ){

      var d=await knex('simspam.non_perpipaan').select('*').where({
        'kode_daerah_simspam':result[dex].kode_daerah_simspam
      }).then(function(rows){

        if(rows.length > 0){
          knex('simspam.non_perpipaan').update(result[dex]).where({
             'kode_daerah_simspam':result[dex].kode_daerah_simspam
           }).then(function(res){
            console.log('update '+result[dex].kode_daerah_simspam);
          });

        }else{

             knex('simspam.non_perpipaan').insert(result[dex]).then(function(res){
            console.log('inputed '+result[dex].kode_daerah_simspam);
          });

        }

      });


    }

}