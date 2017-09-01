CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `setpass_3010` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL,
  `last_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(16) NOT NULL,
  `password` varchar(255) NOT NULL,
  `theme` varchar(64) NULL,
  `language` varchar(64) NOT NULL DEFAULT 'english',
  `email_address` varchar(255) NOT NULL,
  `first_name` varchar(128) NOT NULL,
  `last_name` varchar(128) NOT NULL,
  `psalt` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `configuration` (
  `last_updated_by` int(10) unsigned NOT NULL,
  `last_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `config_setting` varchar(64) NOT NULL,
  `config_value` varchar(255) NOT NULL,
  KEY `config_setting` (`config_setting`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `default_games` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cloudid` int(10) unsigned NOT NULL,
  `port` smallint(5) unsigned NOT NULL,
  `maxplayers` smallint(4) unsigned NOT NULL,
  `startup` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `steam` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `type` enum('game','voice','other') NOT NULL DEFAULT 'game',
  `cfg_separator` varchar(1) NOT NULL,
  `gameq_name` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `intname` varchar(12) NOT NULL,
  `working_dir` varchar(64) NOT NULL,
  `pid_file` varchar(64) NOT NULL,
  `banned_chars` varchar(64) NOT NULL,
  `cfg_ip` varchar(64) NOT NULL,
  `cfg_port` varchar(64) NOT NULL,
  `cfg_maxplayers` varchar(64) NOT NULL,
  `cfg_map` varchar(64) NOT NULL,
  `cfg_hostname` varchar(64) NOT NULL,
  `cfg_rcon` varchar(64) NOT NULL,
  `cfg_password` varchar(64) NOT NULL,
  `map` varchar(255) NOT NULL,
  `hostname` varchar(255) NOT NULL,
  `config_file` varchar(255) NOT NULL,
  `steam_name` varchar(255) NOT NULL,
  `description` varchar(600) NOT NULL,
  `install_mirrors` varchar(600) NOT NULL,
  `install_cmd` varchar(600) NOT NULL,
  `update_cmd` varchar(600) NOT NULL,
  `simplecmd` varchar(600) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `intname` (`intname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `default_startup` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `defid` int(10) unsigned NOT NULL,
  `sort_order` smallint(5) unsigned NOT NULL,
  `single` tinyint(1) unsigned NOT NULL,
  `usr_edit` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cmd_item` varchar(128) NOT NULL,
  `cmd_value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `defid` (`defid`),
  KEY `cmd_item` (`cmd_item`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `loadavg` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `netid` int(10) unsigned NOT NULL,
  `free_mem` int(10) unsigned NOT NULL,
  `total_mem` int(10) unsigned NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `load_avg` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `network` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` int(10) unsigned NOT NULL DEFAULT '0',
  `is_local` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `login_user` blob NOT NULL,
  `login_pass` blob NOT NULL,
  `login_port` blob NOT NULL,
  `ip` varchar(20) NOT NULL,
  `token` varchar(32) NOT NULL,
  `os` varchar(64) NOT NULL,
  `location` varchar(128) NOT NULL,
  `datacenter` varchar(128) NOT NULL,
  `homedir` varchar(255) NULL,
  PRIMARY KEY (`id`),
  KEY `parentid` (`parentid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `plugins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `date_installed` datetime NOT NULL,
  `description` text NOT NULL,
  `intname` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `resellers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL,
  `last_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `language` varchar(64) NOT NULL DEFAULT 'english',
  `username` varchar(16) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `first_name` varchar(128) NOT NULL,
  `last_name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `servers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL,
  `userid2` int(10) unsigned NOT NULL,
  `netid` int(10) unsigned NOT NULL,
  `defid` int(10) unsigned NOT NULL,
  `port` smallint(5) unsigned NOT NULL,
  `maxplayers` smallint(4) unsigned NOT NULL,
  `startup` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `status` enum('none','installing','updating','failed','complete') NOT NULL DEFAULT 'none',
  `date_created` datetime NOT NULL,
  `last_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `token` varchar(32) NOT NULL,
  `map` varchar(255) NOT NULL,
  `rcon` varchar(255) NOT NULL,
  `hostname` varchar(255) NOT NULL,
  `sv_password` varchar(255) NOT NULL,
  `working_dir` varchar(255) NOT NULL,
  `pid_file` varchar(255) NOT NULL,
  `update_cmd` varchar(600) NOT NULL,
  `simplecmd` varchar(600) NOT NULL,
  `description` varchar(600) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `userid2` (`userid2`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `servers_startup` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `srvid` int(10) unsigned NOT NULL,
  `sort_order` smallint(5) unsigned NOT NULL,
  `single` tinyint(1) unsigned NOT NULL,
  `usr_edit` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cmd_item` varchar(128) NOT NULL,
  `cmd_value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cmd_item` (`cmd_item`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `netid` int(10) unsigned NOT NULL,
  `cfgid` int(10) unsigned NOT NULL,
  `steam_percent` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL,
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `status` enum('none','running','steam_running','failed','tpl_running','complete') NOT NULL DEFAULT 'none',
  `size` varchar(12) NOT NULL DEFAULT '0',
  `token` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  `file_path` varchar(400) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `is_default` (`is_default`),
  KEY `cfgid` (`cfgid`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `login_attempts` int(10) unsigned NOT NULL DEFAULT '0',
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `perm_ftp` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `perm_files` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `perm_startup` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `perm_startup_see` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `perm_chpass` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `perm_updetails` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `date_created` datetime NOT NULL,
  `last_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sso_user` blob NOT NULL,
  `sso_pass` blob NOT NULL,
  `theme` varchar(64) NULL,
  `language` varchar(64) NOT NULL DEFAULT 'english',
  `username` varchar(16) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `first_name` varchar(128) NOT NULL,
  `last_name` varchar(128) NOT NULL,
  `psalt` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `default_games` (`id`, `cloudid`, `port`, `maxplayers`, `startup`, `steam`, `type`, `cfg_separator`, `gameq_name`, `name`, `intname`, `working_dir`, `pid_file`, `banned_chars`, `cfg_ip`, `cfg_port`, `cfg_maxplayers`, `cfg_map`, `cfg_hostname`, `cfg_rcon`, `cfg_password`, `map`, `hostname`, `config_file`, `steam_name`, `description`, `install_mirrors`, `install_cmd`, `update_cmd`, `simplecmd`) VALUES
(1, 5, 16567, 32, 0, 0, 'game', ' ', 'bf2', 'Battlefield 2', 'bf2', '', '', '', 'sv.serverIP', 'sv.serverPort', 'sv.maxPlayers', 'mapList.append', 'sv.serverName', '', 'sv.password', 'strike_at_karkand', 'New GamePanelX Server', '', '', 'Next iteration in the Battlefield series', 'http://www.1337-server.net/bf2/serverfiles/bf2-linuxded-1.1.2965-797.0-installer.sh', 'gunzip bf2-linuxded-1.1.2963-795-installer.sh.gz\\nchmod u+x bf2-linuxded-1.1.2963-795-installer.sh\\necho accept | ./bf2-linuxded-1.1.2963-795-installer.sh', '', './start.sh'),
(2, 2, 27015, 24, 1, 1, 'game', ' ', 'source', 'Counter-Strike: 1.6', 'cs_16', '', '', '+- ', 'ip', 'port', 'maxplayers', 'map', 'hostname', 'rcon_password', 'sv_password', 'de_dust2', 'New GamePanelX Server', 'cstrike/cfg/server.cfg', 'cstrike', 'The original Counter-Strike', '', '', './steam -command update -game cstrike -dir .', './hlds_run -game cstrike +ip %IP% +port %PORT% +map de_dust2 +maxplayers 16'),
(3, 3, 27015, 24, 1, 1, 'game', ' ', 'source', 'Counter-Strike: Condition Zero', 'cs_cz', 'czero', '', '+- ', 'ip', 'port', 'maxplayers', 'map', 'hostname', 'rcon_password', 'sv_password', 'de_dust2_cz', 'New GamePanelX Server', 'czero/cstrike/cfg/server.cfg', 'czero', 'Update of CS:1.6 with bots and missions', '', '', './steam -command update -game czero -dir .', './hlds_run -game cstrike +ip %IP% +port %PORT% +map de_dust +maxplayers 16'),
(4, 7, 27015, 24, 1, 2, 'game', ' ', 'source', 'Counter-Strike: GO', 'cs_go', '740', '', '+- ', 'ip', 'port', 'maxplayers', 'map', 'hostname', 'rcon_password', 'sv_password', 'de_dust2', 'New GamePanelX Server', '740/csgo/cfg/server.cfg', '740', 'Counter-Strike: Global Offensive', '', '', './steamcmd.sh +runscript .gpxsteamupdate.txt', './srcds_run -game csgo -ip %IP% -port %PORT% +map de_dust2 +sv_pure 0 +mapgroup mg_bomb -tickrate 66 +maxplayers 12 -maxplayers_override 12 +net_public_adr %IP% +game_type 0 +game_mode 1 +sv_steamgroup_exclusive 1 -console -usercon '),
(5, 1, 27015, 24, 1, 2, 'game', ' ', 'source', 'Counter-Strike: Source', 'cs_s', '232330', '', '+- ', 'ip', 'port', 'maxplayers', 'map', 'hostname', 'rcon_password', 'sv_password', 'de_dust2', 'New GamePanelX Server', '232330/cstrike/cfg/server.cfg', '232330', 'Source version of Counter-Strike', '', '', './steamcmd.sh +runscript .gpxsteamupdate.txt', './srcds_run -game cstrike -ip %IP% -port %PORT% +maxplayers 12 +map de_dust2 -tickrate 66 +mp_dynamicpricing 0'),
(6, 11, 27015, 16, 1, 2, 'game', ' ', 'dods', 'Day of Defeat: Source', 'dod_s', '232290', '', '', 'ip', 'port', 'maxplayers', 'map', 'hostname', 'rcon_password', 'sv_password', 'dod_kalt', 'New GamePanelX Server', '', '232290', 'Day of Defeat Source edition', '', '', '', './srcds_run -console -game dod +map %MAP% +maxplayers %MAXPLAYERS% +ip %IP% -port %PORT%'),
(7, 9, 7777, 8, 0, 0, 'game', ' ', 'samp', 'GTA: San Andreas MP', 'gta_samp', '', '', '', 'bind', 'port', 'maxplayers', 'mapname', 'hostname', 'rcon_password', 'password', '', 'New GamePanelX Server', 'server.cfg', '', '', 'http://gamepanelx.com/files/samp03xsvr_R2_patch1.tar.gz', 'tar -zxf samp03xsvr_R2_patch1.tar.gz\nrm -f samp03xsvr_R2_patch1.tar.gz\nrand_pass=$(date | md5sum | cut -f 1 -d \" \")\nsed -i \\"s/rcon_password\ changeme/rcon_password\ \$rand_pass/g\\" server.cfg', '', './samp03svr'),
(8, 12, 27015, 8, 1, 2, 'game', ' ', 'hl2dm', 'Half-Life 2: Deathmatch', 'hl2_dm', '232370', '', '+- ', 'ip', 'port', 'maxplayers', 'map', 'hostname', 'rcon_password', 'sv_password', 'dm_lockdown', 'New GamePanelX Server', '', '232370', 'Half-Life 2 DM', '', '', '', './srcds_run -game hl2mp +map %MAP% +maxplayers %MAXPLAYERS% +ip %IP% +port %PORT%'),
(9, 6, 25565, 8, 0, 0, 'game', '=', 'minecraft', 'Minecraft', 'mcraft', '', '', '', 'server-ip', 'server-port', 'max-players', 'level-name', 'motd', 'enable-rcon', '', '', 'New GamePanelX Server', 'server.properties', '', 'CraftBukkit Minecraft Server', 'http://gamepanelx.com/files/craftbukkit-latest.tgz', 'tar -zxf craftbukkit-latest.tgz\nrm -f craftbukkit-latest.tgz', '', 'java -Xincgc -Xmx1000M -jar craftbukkit.jar nogui'),
(10, 10, 64738, 16, 0, 0, 'voice', '=', '', 'Murmur', 'murmur', '', 'murmur.pid', '', 'host', 'port', 'users', '', 'welcometext', '', 'serverpassword', '', 'New GamePanelX Server', 'murmur.ini', '', 'Server for the open source Mumble client', 'http://gamepanelx.com/files/murmur-latest-x86.tar.bz2', 'tar -xvjf murmur-latest-x86.tar.bz2\\nrm -f murmur-latest-x86.tar.bz2\\nmv murmur-*/* .\\nrmdir murmur-static*\\nsed -i ''s/\\#pidfile\\=/pidfile\\=murmur\\.pid/g'' murmur.ini', '', './murmur.x86 -ini murmur.ini'),
(11, 8, 27015, 24, 1, 2, 'game', ' ', 'tf2', 'Team Fortress 2', 'tf2', '232250', '', '+- ', 'ip', 'port', 'maxplayers', 'map', 'hostname', 'rcon_password', 'sv_password', 'cp_badlands', 'New GamePanelX Server', '', '232250', 'Free to play update of Team Fortress', '', '', './steamcmd.sh +runscript .gpxsteamupdate.txt', './srcds_run -game tf -ip %IP% -port %PORT% -autoupdate -maxplayers 24 +map cp_badlands'),
(12, 4, 3784, 8, 0, 0, 'voice', '=', 'ventrilo', 'Ventrilo', 'vent', '', 'ventrilo_srv.pid', '', '', '', '', '', '', '', '', '', '', '', '', 'Voice Communication Server', '', '', '', './ventrilo_srv -d');



INSERT INTO `default_startup` (`id`, `defid`, `sort_order`, `single`, `usr_edit`, `cmd_item`, `cmd_value`) VALUES
(1, 2, 0, 0, 0, './hlds_run', ''),
(2, 2, 1, 0, 0, '-game', 'cstrike'),
(3, 2, 2, 0, 0, '+ip', '%IP%'),
(4, 2, 3, 0, 0, '+port', '%PORT%'),
(5, 2, 4, 0, 0, '+maxplayers', '%MAXPLAYERS%'),
(6, 2, 5, 0, 0, '+map', '%MAP%'),
(7, 3, 0, 0, 0, './hlds_run', ''),
(8, 3, 1, 0, 0, '-game', 'czero'),
(9, 3, 2, 0, 0, '+ip', '%IP%'),
(10, 3, 3, 0, 0, '+port', '%PORT%'),
(11, 3, 4, 0, 0, '+maxplayers', '%MAXPLAYERS%'),
(12, 3, 5, 0, 0, '+map', '%MAP%'),
(13, 4, 0, 0, 0, './srcds_run', ''),
(14, 4, 1, 0, 0, '-game', 'csgo'),
(15, 4, 2, 0, 0, '-console', ''),
(16, 4, 3, 0, 0, '-usercon', ''),
(17, 4, 4, 0, 0, '-secure', ''),
(18, 4, 5, 0, 0, '-maxplayers_override', '%MAXPLAYERS%'),
(19, 4, 6, 0, 0, '+sv_pure', '0'),
(20, 4, 7, 0, 0, '+hostport', '%PORT%'),
(21, 4, 8, 0, 0, '+ip', '%IP%'),
(22, 4, 9, 0, 0, '+net_public_adr', '%IP%'),
(23, 4, 10, 0, 0, '+game_type', '0'),
(24, 4, 11, 0, 0, '+game_mode', '0'),
(25, 4, 12, 0, 0, '+mapgroup', 'mg_bomb'),
(26, 4, 13, 0, 0, '+map', '%MAP%'),
(27, 5, 0, 0, 0, './srcds_run', ''),
(28, 5, 1, 0, 0, '-game', 'cstrike'),
(29, 5, 2, 0, 0, '-ip', '%IP%'),
(30, 5, 3, 0, 0, '-port', '%PORT%'),
(31, 5, 4, 0, 0, '+maxplayers', '%MAXPLAYERS%'),
(32, 5, 5, 0, 1, '+map', '%MAP%'),
(33, 5, 6, 0, 0, '+sv_pure', '0'),
(34, 5, 7, 0, 0, '-tickrate', '66'),
(35, 6, 1, 1, 0, './srcds_run', ''),
(36, 6, 2, 0, 0, '-game', 'dod'),
(37, 6, 3, 0, 1, '+map', '%MAP%'),
(38, 6, 4, 0, 0, '+maxplayers', '%MAXPLAYERS%'),
(39, 6, 5, 0, 0, '+ip', '%IP%'),
(40, 6, 6, 0, 0, '+port', '%PORT%'),
(41, 8, 1, 1, 0, './srcds_run', ''),
(42, 8, 2, 0, 0, '-game', 'hl2mp'),
(43, 8, 3, 0, 0, '+map', '%MAP%'),
(44, 8, 4, 0, 0, '+maxplayers', '%MAXPLAYERS%'),
(45, 8, 5, 0, 0, '+ip', '%IP%'),
(46, 8, 6, 0, 0, '+port', '%PORT%'),
(47, 11, 1, 1, 0, './srcds_run', ''),
(48, 11, 2, 0, 0, '-game', 'tf'),
(49, 11, 3, 0, 0, '-ip', '%IP%'),
(50, 11, 4, 0, 0, '-port', '%PORT%'),
(51, 11, 5, 0, 0, '+maxplayers', '%MAXPLAYERS%'),
(52, 11, 6, 0, 0, '+map', '%MAP%'),
(53, 12, 0, 0, 0, './srcds_run', ''),
(54, 12, 1, 0, 0, '-game', 'cstrike'),
(55, 12, 2, 0, 0, '-ip', '%IP%'),
(56, 12, 3, 0, 0, '-port', '%PORT%'),
(57, 12, 4, 0, 0, '+maxplayers', '%MAXPLAYERS%'),
(58, 12, 5, 0, 1, '+map', '%MAP%'),
(59, 12, 6, 0, 0, '-tickrate', '66'),
(60, 12, 7, 0, 1, '+mp_dynamicpricing', '0');
