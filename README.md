# Glifcos
PocketMine-MP server manager run on webserver.  

** NOTE: There is currently some issues running on Windows machine. Linux/Mac works fine. **  

### Introduction  
Hi, thank you for viewing Glifcos. Glifcos is a PocketMine control panel, hosted easily on your webserver.  
It allows for remote management from your own domain, and is very easy to use.  

##### How is this different from Multicraft?  
Well, actually, Glifcos was designed to be an alternative to Multicraft.  
It does technically the same things as Multicraft, but there are some stark differences.  

For example, I believe Mutlicraft requires a modified .phar in order to work, and changes to the core  
configuration files. Meanwhile, all Glifcos requires is a simple plugin installation. The plugin will  
take care of everything with the web server from there.  

##### How stable is Glifcos? Does it crash?  
Glifcos is a fairly stable program you can use. It's still in beta (not stable) release, so there  
are definetly still bugs that I haven't yet worked off.  
The stability of Glifcos will also depend on the webserver you are hosting it on. I have had bad results  
with FatCow web hosting, but a local Apache server was very stable.  

For best results, you will want to use Glifcos with a Unix machine, not Windows.  

##### Is this production ready? Should I use it for my large server network?  
No. I'd prefer not.  
Unfortuantely, I've tested Glifcos with a fairly productive server (40+ plugins, over 1GB .log file)  
and the results were unstable.  

If you want to use Glifcos, it is optimal for small(er) servers. Large production servers should work, but  
with some notable bugs.  

##### What are the requirements?  
You need a webserver, a PocketMine server, and the server.log file to be enabled.  

##### What are some bugs or errors?  
Glifcos varies on performance. There are bugs specific to your host, configuration, and enviornment.  
Don't think that Glifcos is completely unstable and a 'failed' project. I've put it on an Apache instance  
and it was stable. If you put it on Windows, there will defintely be some memory related leaks.  

If you use a stable Apache web host, and a Unix PocketMine server... it will work just fine...  


######For more information, please visit the website or contact the author. Thanks!