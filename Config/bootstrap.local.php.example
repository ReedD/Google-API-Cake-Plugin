Go to: https://code.google.com/apis/console/?api=analytics
1.) Create a "Client ID" of type "Service account"
2.) Download the newly created p12 file, title it "googlekey.p12" and place it into the main
	"Config" folder.
3.) The new service account will also have:
	- "Client ID" which is "GOOGLE_CLIENT_ID"
	- "Email Address" which is "GOOGLE_SERVICE_ACCOUNT_NAME"
4.) You'll also need the "GOOGLE_ANALYTICS_ACCOUNT_ID" this can be found within the Analytics account
	- Navigate to the "profile" you want to query
	- Find the "Profile ID" on the profile settings page
5.) You may get an error that the account does not have an analytics account, you need to add
	the GOOGLE_SERVICE_ACCOUNT_NAME as a user within your analitcs account so we can get access to
	the profile
6.) More information can be found here:
	https://developers.google.com/analytics/devguides/reporting/core/v3/reference

define('GOOGLE_ANALYTICS_ACCOUNT_ID', 'XXXXXXX');
define('GOOGLE_CLIENT_ID', 'Client ID');
define('GOOGLE_SERVICE_ACCOUNT_NAME', 'Email Address');
