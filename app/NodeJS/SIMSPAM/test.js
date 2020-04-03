const { Client } = require('pg');
const pg = require('pg');
const http = require('http');
const querystring = require('querystring');

// config db pertama
const env=require('dotenv').config({path: '../../../.env'})
const { readFileSync, writeFileSync } = require('fs');
const fs = require('fs');


var request = require('request');
var today = new Date();
var dd = today.getDate();

var mm = today.getMonth()+1; 
var yyyy = today.getFullYear();
if(dd<10) 
{
    dd='0'+dd;
} 

if(mm<10) 
{
    mm='0'+mm;
} 
today = yyyy+'-'+mm+'-'+dd;





// kl mau untuk local activkan kedua tutup pertama

// config db kedua
// const env=require('dotenv').config({path: './.env'})

// const client = new Client({
//   host: env.parsed.DB_HOST,
//   port: env.parsed.DB_PORT,
//   user: env.parsed.DB_USERNAME,
//   password:env.parsed.DB_PASSWORD,
//   database:"production_nuwas",
//   query_timeout:1000000,
//   statement_timeout:1000000
// });


// var knex = require('knex')({
//   client: 'pg',
//   connection: {
//     host: env.parsed.DB_HOST,
//     port: env.parsed.DB_PORT,
//     user: env.parsed.DB_USERNAME,
//     password:env.parsed.DB_PASSWORD,
//     database:"production_nuwas",

//   },
//   // pool: {
//   //    host: env.parsed.DB_HOST,
//   //   port: env.parsed.DB_PORT,
//   //   user: env.parsed.DB_USERNAME,
//   //   password:env.parsed.DB_PASSWORD,
//   //   database:"production_nuwas",
//   // },
//   acquireConnectionTimeout: 10000000
// });



// client
//   .connect()
//   .then(() => console.log('connected'))
//   .catch(err => console.error('connection error', err.stack));




// // async function initDb(){
// //   var sql = await fs.readFileSync('./storage/template_table.sql').toString();
// //   console.log(' try connection db ');
// //  setTimeout(function(){
// //     client.query(sql, function(err, result){
// //       if(err){
// //           console.log('error: ', err);
// //           process.exit(1);
// //       }else{
// //          console.log('-- init table db success --');
// //       }
// //       console.log(result);
// //     });
// //   },300);

// // }

// // initDb();

// // client.query('SELECT * from public.master_daerah limit 2 ', (err, res) => {
// //   if (err) {
// //     console.log(err.stack)
// //   } else {
// //     console.log(res.rows[0])
// //   }
// // });

// async function db(){
//   var c='';
//    await client
//   .query("select * from simspam.perpipaan where key='"+'dd'+"' and kode_daerah_simspam='"+'1111'+"' limit 1")
//   .then((res) => {
//     console.log('hasil');
//    c=res.rows[0];
//   }
 
//   )
//   .catch(e => console.error(e.stack));

//   console.log(c);

//   console.log(a);

//   process.exit(0);
// }

 


// db();


// console.log(env.parsed.DB_DATABASE);