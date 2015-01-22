{include file='header'}

<header class="boxHeadline">
	<h1>{lang}wcf.acp.menu.link.style.customLess{/lang}</h1>
</header>

{include file='formError'}

{if $success|isset}
	<p class="success">{lang}wcf.global.success.{$action}{/lang}</p>
{/if}

<div class="contentNavigation">
	<nav>
		<ul>
			{event name='contentNavigationButtons'}
		</ul>
	</nav>
</div>

<form method="post" action="{link controller='CustomLess'}{/link}">
	<div class="container containerPadding marginTop">
		<fieldset class="marginTop">
			<legend>{lang}wcf.acp.style.advanced.individualLess{/lang}</legend>
			
			<dl class="wide">
				<dd>
					<textarea id="individualLess" rows="20" cols="40" name="individualLess">{$individualLess}</textarea>
					<small>{lang}wcf.acp.style.advanced.individualLess.description{/lang}</small>
				</dd>
			</dl>
		</fieldset>
		{include file='codemirror' codemirrorMode='less' codemirrorSelector='#individualLess, #overrideLess'}
		
		{event name='fieldsets'}
	</div>
	
	<div class="formSubmit">
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
		{@SECURITY_TOKEN_INPUT_TAG}
	</div>
</form>

{include file='footer'}