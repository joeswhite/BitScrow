Bitscrow PRE-ALPHA V.0

This is currently a PRE ALPHA proof of concept that i hope someone will help me complete
This project rips parts of many other opensource projects, i need help figuring out the licenses on these.
First this project started as a way for me to make my own escrow system, but then i decided i would release it. After all there is NOTHING out there. This project is incomplete.
The goal of this project is to allow escrow through PHP without bitcoind



YOU ARE REQUIRED TO SUBMIT ANY AND ALL CHANGES TO THIS SOFTWARE TO bitscrow.sourceforge.net
IF YOU DO NOT, YOU WILL BE SUED.INSTALL



upload to directory of your choosing
edit sci/config.php 
seller - your vendor name
site_url - your site base url
confirm_num - number of confirms in the chain before funds released
contact_email - your contact email address
admin_pass admin password for sci/admin.php (will be changed in the future)
sec_str - A random 16 character string. make this up for security
pub_rsa_key - log in to sci/admin.php and generate an RSA key. (WRITE THIS DOWN, YOU LOSE YOUR MONEY IF YOU DONT. once you generate that key, copy the public rsa key and insert it into the variable pub_rsa_key.
mysvr - Mysql server hostname
mydb - Your mysql database. If you can set it to whatever you want. PLEASE ADD escrow to database, or change variable to your database name
myusr - Mysql username
mypass - MYSQL password




What works:
You can request escrow
The "admin" panel from sci still works
all escrow system information is added in to the system.
The system validates bitcoin
Verify coin is in our hands is workable
Seller can verify funds are in escrow via FVP (funds verification pin) and entering in wallet info.
seller can get funds released to them via WIF after buyer gives FVP and FRP.
Working system concept.

How I plan on doing this currently:
I plan on the buyer giving the seller a finialize release pin, the seller enters that code along with other information (wallet) and gets his Wallet Import File. I know that this is not the most secure way to do this, but this aleviates the need for payment fees incurred by the escrow. I will highly encourage every user to transfer funds out of their account and in to a new account. This is done like this as I am not sure how to transfer funds without using bitcoind. (I want this to be php only)
Eventually i would like to work in a refund system where the buyer and seller cna agree to release for instance 33% funds and give a return of 67% to buyer. This will be all automated of course. I also will be adding a way that the buyer can agree to pre-release a certian % or number of btc. This can be helpful for the vendor to get the product shipped if they are a small business, if they are a large one, it may help the business procure an item otherwise unavailable.

I know i am missing a lot, but this does have the database.
PLEASE help me make this great for everyone!



YOU ARE REQUIRED TO SUBMIT ANY AND ALL CHANGES TO THIS SOFTWARE TO bitscrow.sourceforge.net
IF YOU DO NOT, YOU WILL BE SUED.


J. White 2013