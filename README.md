# Section Field plugin for Craft CMS 4.x

Creates a section selector field in the CMS

## Requirements

This plugin requires Craft CMS 4 or later. For Craft 3 please use version 1.0.0

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

```
cd /path/to/project/craft
```

2. Then tell Composer to load the plugin:

```
composer require towardstudio/sectionfield
```

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Website Documentation.

## Usage

### Sections

```
{% set sections = craft.sectionField.sections(entry.myFieldHandle) %}

{% for section in sections %}
	{{ section.name }}
{% endfor %}
```

### Entries from the selected section/s

```
{% set entries = craft.sectionField.entries(entry.myFieldHandle) %}

{% for entry in entries.all() %}
	{{ entry.title }}
{% endfor %}
```

[Toward Disclaimer](https://github.com/towardstudio/toward-open-source-disclaimer)

Brought to you by [Toward](https://toward.studio)
