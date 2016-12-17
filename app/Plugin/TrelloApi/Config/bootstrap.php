<?php
/**
 * Application key
 * @link https://trello.com/1/appKey/generate
 */
Configure::write('TrelloApi.key', 'c824dcc2d054e14643d3111a8e2715ad');
/**
 * Application secret
 * @link https://trello.com/1/appKey/generate
 */
Configure::write('TrelloApi.secret', 'dedb005234f7cc8fbe774e386fdafa74118f77eda087870187519433059a8530');

/*
 * application name
 */
Configure::write('TrelloApi.appName',"CRM - Tricipta Media Perkasa");

/**
 * API URL without trailing slash
 */
Configure::write('TrelloApi.url', 'https://api.trello.com');
/**
 * API version number
 */
Configure::write('TrelloApi.version', '1');
/**
 * OAuth request token URL
 */
Configure::write('TrelloApi.requestTokenUri', 'https://trello.com/1/OAuthGetRequestToken');
/**
 * OAuth authorization URL (use %s for request token key)
 */
Configure::write('TrelloApi.authorizeUri', 'https://trello.com/1/OAuthAuthorizeToken?oauth_token=%s&expiration=never&scope=read,write');
/**
 * OAuth access token URL
 */
Configure::write('TrelloApi.accessTokenUri', 'https://trello.com/1/OAuthGetAccessToken');