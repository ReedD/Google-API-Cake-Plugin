# Google API Cake Plugin #

Currently I've only build in support for Google Analytics but you could easily modify it to support other Google APIs. If you add further support please feel free to help by contributing to this project. If you have any questions or comments you can email me at <Reed@Dadoune.com>.

## Google API Setup ##
1. Go to: [Google APIs](https://code.google.com/apis/console/?api=analytics "Google APIs")
2. Create a **Client ID** of type **Service account**
3. Download the newly created p12 file, title it **googlekey.p12** and place it into the main
	"Config" folder.
4. The new service account will also have:
	* **Client ID** which is **GOOGLE_CLIENT_ID**
	* **Email Address** which is **GOOGLE_SERVICE_ACCOUNT_NAME**
5. You'll also need the **GOOGLE_ANALYTICS_ACCOUNT_ID** this can be found within the Analytics account
	* Navigate to the profile you want to query
	* Find the **Profile ID** on the profile settings page
6. You may get an error that the account does not have an analytics account, you need to add
	the **GOOGLE_SERVICE_ACCOUNT_NAME** as a user within your analytics account so we can get access to
	the profile
7. More information can be found at Google API Reference [Documentation](https://developers.google.com/analytics/devguides/reporting/core/v3/reference "Google API Reference")
	

## Cake Setup ##

1. Add the following code to your local bootstrap with the information gathered from the above steps:

		define('GOOGLE_ANALYTICS_ACCOUNT_ID', 'XXXXXXX');
		define('GOOGLE_CLIENT_ID', 'Client ID');
		define('GOOGLE_SERVICE_ACCOUNT_NAME', 'Email Address');
		
2. You can then add shell scripts to periodically (on a cronjob) cache data from google analytics via shell command.  An example can be seen here `Console/Command/AnalyticsShell.php.example`, demonstrating how you might update a model view count based on it's path/slug.
