@component('mail::message')
# Hi, there!

<br>

Thanks for signing up to manage your property. During your free trial, you can use all the features of The Property Manager. 
Should you need help with setting up your property or with using any of the features of the application, 
feel free to send us a message through the messenger chatbot, located at the bottom left corner, available 
at any given time or email us at customercare@thepropertymanager.online. 

<br>
<br>
Email: jamesdavid_11@yahoo.com
<br>
Password: 12345678


<br>
@component('mail::button', ['url' => 'thepropertymanager.online/property/all'])
Add your first property
@endcomponent
<br>

Hope to hear from you soon!

Cheers,<br>
{{ config('app.name') }}
@endcomponent
