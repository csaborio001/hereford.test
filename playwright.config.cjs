const {defineConfig}=require('@playwright/test');
module.exports=defineConfig({testDir:'./tests',timeout:30000,retries:0,workers:1,reporter:[['list'],['html',{open:'never'}]],use:{baseURL:"https://hereford-net-au.test",ignoreHTTPSErrors:false,trace:'retain-on-failure',screenshot:'only-on-failure'}});
