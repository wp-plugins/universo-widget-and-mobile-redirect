=== Universo Widget and Mobile Redirect ===
Contributors: Eduardo Russo
Tags: universo, android, java, iphone, widget, mobile, redirect, devices, app, universo.mobi
Requires at least: 2.5
Tested up to: 3.3.2
Stable tag: 2.4.1

Displays Universo's (http://universo.mobi) App link in the sidebar and add a Mobile Recognition tool to redirect your reader using mobile devices to your Universo App URL.

== Description ==
Português:
Se você criou seu App com o Universo em http://universo.mobi, este Plugin permite colocar um Widget com seu link na barra lateral, assim, os leitores do seu blog podem acessa seu App do Universo pelo QRCode ou por um link.

Você pode escolher inserir o Ícone e o QRCode do seu App, os ícones dos dispositivos compatíveis com seu App do Universo, além de poder adicionar um texto com formatação HTML.

Além disso, o Widget tem um checkbox para escolher entre usar ou não um Reconhecedor de Celulares que redireciona os usuários usando dispositivos móveis para seu App do Universo! 

English:
If you created your Universo App at http://universo.mobi, this Plugin allows you to insert  Widget with the App link in the sidebar, so your blog readers can access your Universo Mobile App via QRCode or Link.

You can choose to insert your App Icon and QRCode, the icons of the mobile phones compatible with Universo and a customized text with HTML formating.

Besides all that, the Widget has a checkbox to select to use or not a Mobile Recognition tool abble to redirect your readers using Mobile Devices to your Universo App!

== Installation ==

Português:
1. Suba o Plugin universo-widget-and-mobile-redirect para a pasta wp-content/plugins/.

2. Ative o Plugin na aba Plugins do Painel de Administração do WordPress.

3. Vá para a página Widgets no Painel de Administração e arraste o Widget para a barra do seu blog. Insira o endereço do seu App do Universo (http://universo.mobi/universo, por exemplo) e altere as configurações de aparência do Widget.

4. A opção "Redirecionar usuários móveis" faz com que usuários acessando seu blog através do celular sejam redirecionados para seu App do Universo.

5. O arquivo "universo.css" pode ser facilmente alterado para que as imagens se comportem da forma que você quiser. Vá para a aba Plugins e escolha a opção "editar". Selecione o arquivo CSS.


English:
1. Upload the entire universo-widget-and-mobile-redirect to your wp-content/plugins/ directory.

2. Activate the Plugin through the 'Plugins' menu in WordPress.

3. Go to the Widgets page in the Admin Pannel and drag the Widget to your blog bar. Insert your Universo App URL (http://universo.mobi/universo, for instance) and change the way you want your Widget to look like.

4. The option "Redirect mobile users" redirects people accessing your blog from mobile devices to your Universo App.

5. The "universo.css" file can be changed to make the images fit your space. Just go to the Plugins tab and choose the "edit" option. Select the CSS File.

== Screenshots ==

1. Widget Form
2. Widget Sidebar in use
3. Universo Mobile App

== Changelog ==  

= 0.1 =
* First tests with the Widget

= 1.0 =
* First working version

= 1.0.1 =
* Mobile redirection correction

= 1.5 =
* Mobile redirection correction

= 2.0 =
* Universo compatible Phone Icons
* Now, it's possible to change the fields order

= 2.2 = 
* Using new Universo.mobi QRCode engine
* Sending "feature" param to QRCode
* Calling Universo.mobi using get_meta_tags with an user agent

= 2.3 =
* Corrected QRCode icon size bug

= 2.3 =
* Minor bug correction on UA request