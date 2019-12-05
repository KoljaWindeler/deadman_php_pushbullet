# deadman_php_pushbullet

## Motiviation
I'm using Home-Assistant to automate and controll quite a few things in my home.
At some point I've realized that I rely so much on a stable operation that I'd like
to have some safety mechanism that informs me if something happens.

That something can be everything from internet outage / power failure / SDD crash /
OS crash / Homeassistant crash. Granted, most of this hasn't happened yet. But I've
seen Homeassistant crashing about once per year. 

If this happens on the first day of a vaccation trip and I wouldn't check in (via vpn) 
some minor trouble could happen. Irigation system to water plants wouldn't work, motion 
triggered safety system wouldn't react, ventilation system, presents simulation ... 
I guess everyone has its own list.

There are some solution already on the market, but all of them require to check in on 
your server. My installation is completely shielded from the outside (well, besides VPN)
and I'd prefere to keep it this way. Thats why I've build this service. Deadman PHP pushbullet.

### This is how it works:
An automation within homeassistant calls a url. This call resets a timer.
If homeassistant won't checkin after a given time, the server will send a message via pushbullet
to inform me. Thats it. 

So as long as everything is up and running, this will never trigger and I'll never get a message.

## Setup
1. copy this file https://raw.githubusercontent.com/KoljaWindeler/deadman_php_pushbullet/master/yaml/deadman.yaml
to your package folder. (https://www.home-assistant.io/docs/configuration/packages/#create-a-packages-folder)
2. get a Pushbullet token: https://www.pushbullet.com/#settings/account -> Create access token 
3. Add the token to your secrets.yaml: "pushbullet_key: YOURTOKENGOESHERE"

## Addition
You can find the source code of all php scripts / database layout in this respository. 
If you see a way to improve, please do and send me a pull_request.

### You can modify the automation (in deadman.yaml):

    minutes: "/3" 
  
This provides the update rate, so basically how often homeassistant will reset the counter. 
My impression is that 3 minutes updates is already fairly quick. You can of cause change it to a lower rate.
 
    delay: 600
 
This parameter tells the server to trigger 600 sec after the last reset. So 10 min.
I think this is reasonable, but you might want to change it to 3600 -> 1h to avoid
messages whenever you tinker on your installation. Minimum is 180. Always set this 
value higher than the update rate above, otherwise you'll get many messages.

To keep the load of the server low, it'll check the timer status only every two minutes.
So worse case your push bullet message will come after 10+2 minutes.

### testing
Simply open the developer tools -> service and run:
homeassistant.turn_off and select automation.deadman_reset as entity. 
This will stop the resetting and thus will trigger the switch after the timeout.


### the server
The script runs on a professionally hosted server. I don't plan to take it offline 
as it is running quite a lot of services on other URLs. But I won't garantuee its
operation ... obviously. You can always install the service on your own server of cause.
