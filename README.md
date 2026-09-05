# Oryk Launcher for FreePBX

A lightweight dashboard launcher for FreePBX that provides quick access to commonly used administration pages and displays summary counts for key PBX resources.

## Features

- Responsive, tile-based launcher interface
- Quick links to:
  - User Management
  - Extensions
  - Trunks
  - Inbound Routes
  - Outbound Routes
  - Oryk Devices
  - Call Detail Records (CDRs)
  - Oryk GUI
- Displays record counts where the corresponding database table exists
- Respects the logged-in administrator's FreePBX section permissions
- Uses Font Awesome icons from the FreePBX interface
- Compatible with FreePBX 16 and 17

## Requirements

- FreePBX 16 or 17
- PHP supported by the installed FreePBX version
- FreePBX Core module
- FreePBX User Management module
- Administrator access to install and enable modules

Some launcher entries require the related FreePBX or Oryk module to be installed.

## Installation

### Manual installation

Clone or copy the repository into the FreePBX modules directory:

```bash
cd /var/www/html/admin/modules
git clone https://github.com/alainmenag/freepbx-oryk-launcher.git oryk_launcher
```

Set the appropriate ownership:

```bash
fwconsole chown
```

Install the module and reload FreePBX:

```bash
fwconsole ma install oryk_launcher
fwconsole reload
```

After installation, sign in to the FreePBX administration interface and open the **Oryk Dashboard** entry.

### Updating

From the module directory:

```bash
cd /var/www/html/admin/modules/oryk_launcher
git pull
fwconsole ma upgrade oryk_launcher
fwconsole chown
fwconsole reload
```

## How It Works

The module creates a launcher page containing tiles for supported FreePBX sections.

Before displaying most tiles, it checks the current administrator's permissions using FreePBX section access controls. Record totals are retrieved only when the corresponding database table exists. Missing tables and database query errors are handled without preventing the launcher from loading.

The following database tables are currently used for counts:

| Launcher item | Database table |
| --- | --- |
| Users | `userman_users` |
| Extensions | `users` |
| Trunks | `trunks` |
| Inbound Routes | `incoming` |
| Outbound Routes | `outbound_routes` |
| Devices | `devices` |
| CDRs | `cdr` |

The Oryk GUI tile does not display a database count.

## Project Structure

```text
.
├── assets/
│   └── css/
│       └── launcher.css
├── views/
│   └── launcher.php
├── functions.inc.php
├── module.xml
├── Oryk_launcher.class.php
├── page.index.php
└── page.oryk_launcher.php
```

- `module.xml` — FreePBX module metadata, dependencies, and menu registration
- `Oryk_launcher.class.php` — launcher construction, permission checks, and database counts
- `views/launcher.php` — launcher page markup
- `assets/css/launcher.css` — responsive tile styling
- `page.index.php` and `page.oryk_launcher.php` — FreePBX page entry points
- `functions.inc.php` — optional FreePBX hooks

## Adding a Launcher Item

Launcher items are defined in `Oryk_launcher.class.php` inside the `getLaunchable()` method.

A permission-controlled item follows this structure:

```php
if ($_SESSION['AMP_user']->checkSection('section_name')) {
    $launchable[] = [
        'label' => 'Example',
        'count' => $this->getCount('database_table'),
        'icon'  => 'fa-example',
        'link'  => '/admin/config.php?display=example',
    ];
}
```

For an item without a count, omit the `count` entry:

```php
$launchable[] = [
    'label' => 'Example',
    'icon'  => 'fa-example',
    'link'  => '/admin/config.php?display=example',
];
```

Use a Font Awesome icon class supported by the installed FreePBX interface.

## Installation Behavior

During installation, the module sets the FreePBX `SHOWLANGUAGE` configuration value to `0`.

Review this behavior before installing the module if the language selector is required in your environment.

The module metadata currently marks the module as non-disableable and non-uninstallable through FreePBX Module Administration.

## Development Notes

The module metadata identifies the package as:

- Raw module name: `oryk_launcher`
- Display name: `Launcher`
- Publisher: `Oryk`
- Module type: `setup`
- Category: `Oryk`

After changing PHP, view, or CSS files, run:

```bash
fwconsole chown
fwconsole reload
```

You may also need to clear your browser cache before stylesheet changes become visible.

## Troubleshooting

### The launcher is empty

Confirm that:

- You are signed in to the FreePBX administration interface.
- Your administrator account has access to the relevant FreePBX sections.
- The required FreePBX modules are installed.

### A tile does not display a count

A count is omitted when:

- The associated database table does not exist.
- The database query fails.
- The launcher item does not define a count.

### A link returns “Access Denied”

The destination module may be missing, disabled, or unavailable to the current administrator.

### Styles are not loaded

Confirm that the stylesheet is installed at:

```text
/var/www/html/admin/modules/oryk_launcher/assets/css/launcher.css
```

Also verify that the module's asset registration points to the installed stylesheet.

## Security

Launcher visibility is based on FreePBX administrator section permissions. Access control must also be enforced by each destination FreePBX module.

Do not expose the FreePBX administration interface directly to the public internet. Use appropriate firewall rules, trusted networks, VPN access, and strong administrator authentication.

## License

The module metadata declares this project as licensed under the GNU Affero General Public License version 3 (`AGPLv3`).

See the GNU AGPL version 3 for the complete license terms.

## Author

Published by [Oryk](https://oryk.com/).

Additional information: [Oryk VoIP Launcher](https://oryk.com/voip/launcher)
