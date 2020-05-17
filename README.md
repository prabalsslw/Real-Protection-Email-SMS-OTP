# Real Protection OTP & Woocommerce SMS/Email Alert

RP is an SMS & Email based OTP service provider plugin. Also available woocommerce transactional alert.
## Features!
  - OTP SMS
  - OTP Email
  - New user registration alert
  - Woocommerce transaction alert
  - Configurable custom API & Parameters
  - Dynamic variable.

### Prerequisites
  - Wordpress 5.x.x
  - WooCommerce 4.1.x
  - cURL php extension.

### Version
  - RP V1.0.1
  - Tested up to WooCommerce 4.1

### Download
```sh
Using HTTPS 
$ git clone https://github.com/prabalsslw/RP-OTP-Woocommerce.git
Using SSH 
$ git clone git@github.com:prabalsslw/RP-OTP-Woocommerce.git
```
### Installation
Follow the installation steps.
- Step 1: Upload the plugin to wordpress admin panel. [Img-1]
- Step 2: Go to `Real Protection` > `OTP Settings` page.
- Step 3: Enable OTP checkbox for OTP & SMS Alert. `OTP SMS Text` must contain `{{OTP}}` dynamic variable. [Img-2]
- Step 4: Both GET & POST API can be configurable, use API Endpoint, pass the API parameter with dynamic variable. Fixed dynamic variables: `{{phone_number}}, {{unique_id}}, {{sms_text}}`
[Img-3]
- Step 5: In the `Woocommerce Alert Configuration` part must enable `
Enable Woocommerce Alert` for Woocommerce transaction alert. [Img-4]
- Step 6: Enable your required Hook for transactional alert. [Img-4]
- Step 7: You can change your `Woocommerce SMS Alert Templete`. Fixed dynamic variables: `{{name}}, {{status}}, {{amount}}, {{currency}}, {{order_id}}`. [Img-5]
- Step 8: You can change your `User Registration Alert Templete`. Fixed dynamic variables: `{{name}}`. [Img-5]
- Step 9: After successfully integrating the plugin you can see the reflection in the login and registration page. [Img-6]
- Step 10: Plugin will add an extra field(Phone Number) in the registration form. [Img-7]
- Step 11: Admin can check OTP & Alert SMS record from the admin panel . [Img-8]

### Image Reference
[Img-1] :
![RP Plugin](image/Plugin.jpg)
[Img-2] :
![RP Plugin](image/setuppage.jpg)
[Img-3] :
![RP Plugin](image/setuppage2.jpg)
[Img-4] :
![RP Plugin](image/Setuppage3.jpg)
[Img-5] :
![RP Plugin](image/Setupage4.jpg)
[Img-6] :
![RP Plugin](image/Login.jpg)
[Img-7] :
![RP Plugin](image/Signup.jpg)
[Img-7] :
![RP Plugin](image/History.jpg)

### License
----
- `GPL2`
### Contributor
> Author: Prabal Mallick

> [Support Email](mailto:prabalsslw@gmail.com)