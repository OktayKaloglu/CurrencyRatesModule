# CurrencyRatesModule
An currency rate module for e-commerce companies.



<p>- CurrencyRates app shows currency rates that gathered from various vendors, based on the user's preferences. 
<p>- Users can specify their preferences about which currency they want to see and wich vendor will sullpy the the rates to them. Users can change their preferences at any time. 
<p>- Users can serach all the recorded rates as well as rates at a given time. 
<p>- Users can create api tokens and can retrive rates from the api /api/rates?api_token= &date= &code=. Requests require api_token for authorization purposes .Request        dosen't require any code or date values, if request does not have any of them , response won't be filtered for them. Date has to be m/d/y formation such as        09/05/2022, Codes has to be majorcode/minorcode formation such as EUR/TRY.


Database Schema:
![image](https://user-images.githubusercontent.com/101494182/189290437-5e0eeec7-26a9-490d-947d-7130410ac9b8.jpg)



->login:
![image](https://user-images.githubusercontent.com/101494182/189293313-3783ec68-4345-45f9-9bab-c2b593d4af5a.png)
->register:
![image](https://user-images.githubusercontent.com/101494182/189293572-78d48f0d-5c10-4b32-b1df-43e05907c468.png)
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
![image](https://user-images.githubusercontent.com/101494182/189582926-f2b191e2-c52d-4c3c-ba34-e17f95f6b1d8.png)
![image](https://user-images.githubusercontent.com/101494182/189582984-2861992b-67f9-45a4-a122-2eaba3d10fdb.png)
![image](https://user-images.githubusercontent.com/101494182/189583030-6cbc93b6-0bd6-443a-9ef4-6ead8b0003ea.png)


->api tokens:
![image](https://user-images.githubusercontent.com/101494182/189295370-24d1ab15-80ce-496b-9e67-bc1d6b503c55.png)

