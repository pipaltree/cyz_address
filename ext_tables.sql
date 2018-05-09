#
# Extend table structure of table 'tt_address'
#
CREATE TABLE tt_address (
  sorting INT(11) UNSIGNED DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob
);
