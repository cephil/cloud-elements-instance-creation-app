###################################################################################
##     Cloud-Elements Instance Creation (OAuth) App Example                      ##
###################################################################################

```Copyright 2012-2015 Cloud Elements <http://www.cloud-elements.com>          

Licensed under the Apache License, Version 2.0 (the "License"); you may not
use this file except in compliance with the License. You may obtain a copy of
the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
License for the specific language governing permissions and limitations under
the License.```

##########################
##     Description      ##
##########################
Sample PHP Application describing how to use the Cloud-Elements instances API. This application uses a combination of PHP, OAuth, and Curl to communicate with Box.com's OAuth service and Cloud-Elements RESTful API. The purpose of this application is to show an example of how an end user can connect their individual Box account to an application being developed by a Cloud-Elements customer.

##########################
##     Requirements     ##
##########################
* PHP 5.6

##########################
##         Setup        ##
##########################

## STEP 1 ##
First, you will need both your User secret and Org secret tokens from the Cloud-Elements web application (http://console.cloud-elements.com). Once you have these, place them in the $uSec (User Secret) and $oSec (Org Secret) variables listed in server.php.

```
  $baseUrl = 'https://console.cloud-elements.com/elements/api-v2/';
  $uSec = 'enter Cloud-Elements user secret';
  $oSec = 'enter Cloud-Elements organization secret';
```

## STEP 2 ##
Retrieve your Box developer secrets (client_id and client_secret) at http://developers.box.com and place them in the $apiKey (client_id) and $apiSec (client_secret) variables located in index.php.

```
  $apikey = 'enter box client_id';
  $apiSec = 'enter box client_secret';
  $callbackUrl = 'http://127.0.0.1:8080/index.php';
```

You will also need to define a proper callback url on the Box developer page, and replace the $callbackUrl with this value (if your environment is running at a different location/port).

## STEP 3 ##
Open up your web browser, and open index.php (or the root folder, if located there).

##########################
##          Code        ##
##########################

####index.php
This is the main file, which handles the initial calls to retrieve the proper OAuth url to box, as well as the return after the user has entered their account details on Box and returned to the callback url. It handles the proper rendering of the page, and the redirect when box provides the provisioning code after authentication.

####server.php
This file contains the Cloud-Elements secrets for your account, and the RESTful Curl example that gets used for various API calls.

####showList.php
This file is where index.php redirects to, once the OAuth handshake and instance creation have been completed. Once the user arrives at this page via redirect, an API call is made to list all Box instances associated with the Cloud-Elements account.

##########################
##        License       ##
##########################

```
Copyright 2012-2015 Cloud Elements <http://www.cloud-elements.com>

Licensed under the Apache License, Version 2.0 (the "License"); you may not
use this file except in compliance with the License. You may obtain a copy of
the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
License for the specific language governing permissions and limitations under
the License.
```
