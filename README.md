# CurrencyRatesModule
An currency rate module for e-commerce companies. 


 
<p>- CurrencyRates app show currency rates based on the user's preferences. 
<p>- Users can specify their preferences about which currency they want to see and from which vendor.Users can change this preferences at any time. 
<p>- Users can serach all the recorded rates as well as rates at a given time. 
<p>- Users can create api tokens and can retrive rates from the api /api/rates?api_token= &date= &code=. Requests require api_token for authorization purposes .Request        dosen't require code and date values, if request does not have any of them response is not going to be  filtered for code or filter.  date has to be m/d/y such as        09/05/2022, codes havs to be majorcode/minorcode such as EUR/TRY


Database Schema:
![image](https://user-images.githubusercontent.com/101494182/189290437-5e0eeec7-26a9-490d-947d-7130410ac9b8.jpg)



->login:
![image](https://user-images.githubusercontent.com/101494182/189293313-3783ec68-4345-45f9-9bab-c2b593d4af5a.png)
->register:
![image](https://user-images.githubusercontent.com/101494182/189293572-78d48f0d-5c10-4b32-b1df-43e05907c468.png)
->after login:
![image](https://user-images.githubusercontent.com/101494182/189293771-1679f54c-37ec-492f-b7d1-7bf41d501476.png)
->after login:
![image](https://user-images.githubusercontent.com/101494182/189293771-1679f54c-37ec-492f-b7d1-7bf41d501476.png)
->rates:
![image](https://user-images.githubusercontent.com/101494182/189293838-f95f36d3-abb2-4afe-ae1c-a2fce7b95fd4.png)
->search:
![image](https://user-images.githubusercontent.com/101494182/189294095-76cd3648-dbb6-44b3-8d17-252eefa0619a.png)
->vendors:
![image](https://user-images.githubusercontent.com/101494182/189294773-f36dd232-4680-45b3-8662-3189e2dcc088.png)
->parities:
![image](https://user-images.githubusercontent.com/101494182/189294832-423bfdf9-76e5-4501-b004-d5106bb334e4.png)
->user settings:
![image](https://user-images.githubusercontent.com/101494182/189294922-99ede250-8fa0-482a-8493-bf5ffcd7c661.png)
->account settings:
![image](https://user-images.githubusercontent.com/101494182/189295039-431d2afa-a0b5-4f4e-8227-5f62228b78fd.png)
->Currency Preferences:
![image](https://user-images.githubusercontent.com/101494182/189295200-c56ace8c-92b7-4fa1-907f-adc12dbdc1e5.png)
![image](https://user-images.githubusercontent.com/101494182/189295288-19f4e3de-a149-46d2-88ef-ce9602948f05.png)
![image](https://user-images.githubusercontent.com/101494182/189295308-fbd80ca5-15e1-454f-b7a1-56cb030fa5a1.png)

</p>
<p>
->api tokens:
![image](https://user-images.githubusercontent.com/101494182/189295370-24d1ab15-80ce-496b-9e67-bc1d6b503c55.png)

</p>
