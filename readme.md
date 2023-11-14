# Full Stack Challenge

This is a simple app created in Laravel. You can use the "sample-data.csv" file to upload dummy data using the bulk upload section.

---

## Pre - Challenge

Create a PGP key.
Once you have completed the challenge, send an encrypted email, confirming your availability for Telephonic Technical Interview during the week, to cecile@womenfirstdigital.org with your public PGP key attached.

You will find the public key for cecile@womenfirstdigital.org here https://drive.google.com/file/d/11J1RAMaz422M7if4zaDSjwk5M-NpND4E/view?usp=sharing

---
## Problems

1.  This app has default authentication enabled. You need to alter the code to
	- disable the registration form and restrict self-registration.
	- enable role-based authentication. The app needs to have below roles
		- **admin**
		This is the root user and has access to the entire application. The admin user can add more users, delete / ban users.
		- **supervisor**
		This is a regular user and has the ability to add / bulk upload / view the referrals.
		- **executive**
		This is a regular user and has the ability to view the referrals. However, they can add comments on the referrals. (A separate table needs to be created for storing the comments. Comments will be visible to all users)

2. Currently, the view referrals section has filters on country and city (filters are visible only if there are more than one countries / cities)
We need enable search / filters on all columns so that the executives are able to quickly search down the data.
You need to alter the code to make the view referrals interface better ( Use your creativity )

**Login details to the admin account**
email: a@d.min
password: a@d.min
