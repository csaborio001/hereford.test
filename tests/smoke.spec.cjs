const {test,expect}=require('@playwright/test');
const fs=require('node:fs');
test('homepage and stylesheet',async({page,request})=>{
 const r=await page.goto('/'); expect(r.status()).toBe(200);
 await expect(page.locator('body')).toBeVisible();
 const css=await request.get('/wp-content/mu-plugins/dist/css/hereford-net-au.min.css'); expect(css.ok()).toBeTruthy(); expect((await css.body()).length).toBeGreaterThan(0);
});
test('administrator login',async({page})=>{
 const credentials=JSON.parse(fs.readFileSync('.scorpiotek/credentials.json'));
 await page.goto('/wp-login.php'); await page.locator('#user_login').fill(credentials.user);
 await page.locator('#user_pass').fill(credentials.password); await page.locator('#wp-submit').click();
 await expect(page.locator('#wpadminbar')).toBeVisible();
});
