Mad Blanks automatically checks for the language currently being used by the
Joomla core and it looks for files of the same language in the
<Joomla_root>/administrator/components/com_madblanks/language directory.

The following English language files ship with Mad Blanks:

en-US.com_madblanks.category.php
en-US.com_madblanks.core.php
en-US.com_madblanks.record.php
en-US.com_madblanks.scorescript.php

The file "en-US.com_madblanks.core.php" is the main language file that comes
with Mad Blanks. Inside this file you can edit the various strings that
Mad Blanks uses. The file "en-US.com_madblanks.category.php" contains
instructions and notes that display when an administrator is editing a
Mad Blanks category. Similarly, the contents of
"en-US.com_madblanks.record.php" appear when an administrator is editing a
Mad Blanks record and the contents of "en-US.com_madblanks.scorescript.php"
appear when an administrator is editing a Score Script (when the "Special
tags quick reference section" is expanded).

For example, if the Joomla language/culture code currently in use for the
Joomla core on the front end is es-ES, then Mad Blanks will look for the
following file in the
<Joomla_root>/administrator/components/com_madblanks/language directory:

es-ES.com_madblanks.core.php

And if the Joomla language/culture code currently in use for the Joomla core
on the back end is pt-BR, then the administrator area of Mad Blanks will look
for the following files in the
<Joomla_root>/administrator/components/com_madblanks/language directory:

pt-BR.com_madblanks.category.php
pt-BR.com_madblanks.record.php
pt-BR.com_madblanks.scorescript.php

If Mad Blanks cannot find one or more files that match the language currently
being used by the Joomla language configuration, it will use the English
language (en-US) files by default.

No one thus far has provided me any translation files. To make your own,
simply copy the English language files to ones with the appropriate
language/culture code and translate whichever strings you want.