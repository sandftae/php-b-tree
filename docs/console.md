# Working inside the container

[Back to README](../README.md)

`make btree` covers the usual cases.
This page is for the times when you want to type the commands yourself.
Everything here happens inside the PHP container, so on your machine you still need only Docker and make.

## Contents

- [Open a shell](#open-a-shell)
- [The command](#the-command)
- [Flags](#flags)
- [Examples](#examples)
- [Number set files](#number-set-files)
- [Composer](#composer)
- [Leave the container](#leave-the-container)
- [Run without Docker](#run-without-docker)

## Open a shell

Run this in the project folder on your machine.

```bash
make shell
```

The first run builds the image and installs the PHP packages, the next runs open the shell at once.
You land in `/app`, and `/app` is your project folder.
Files that you make here appear on your machine right away.

> [!NOTE]
> The prompt may start with `I have no name!`. This is fine.
> The container runs as your user, so the files it makes belong to you.
> Your user id simply has no name inside the container.

## The command

The tree is built by `bin/console`.

```bash
bin/console -t btree -c 3 -s "1, 2, 3, 4, 5, 6" -g -d
```

Run `bin/console` without flags to see its own help.

## Flags

| Flag | What it means | Default | Same value in make |
|---|---|---|---|
| `-t btree` | The processor to run. It is required, and `btree` is the only one. | none | `make btree` adds it |
| `-c 5` | The most children a node can have, so a node holds up to capacity minus 1 keys. Values below 3 become 3. | 3 | `capacity=5` |
| `-s "1, 2, 3"` | The numbers for the tree, separated by commas and put in quotes. Repeated numbers are used once. | numbers from -100 to 100 | `set="1, 2, 3"` |
| `-f name.json` | A JSON file with numbers from `media/number-sets`. It wins over `-s`. | not used | `file=name.json` |
| `-g` | Draws the tree as a picture in `media/graph`. | no picture | `graph=1` |
| `-d` | Saves the tree as JSON in `media/dump`. | no dump | `dump=1` |

> [!NOTE]
> Without `-g` and `-d` the tree is still built, but nothing is saved.

## Examples

Each row shows a make command on your machine and the same command inside the container.

| make, on your machine | bin/console, inside the container |
|---|---|
| `make btree capacity=5 set="1, 2, 3, 4, 5, 6" graph=1 dump=1` | `bin/console -t btree -c 5 -s "1, 2, 3, 4, 5, 6" -g -d` |
| `make btree file=num_set_exmpl.json graph=1` | `bin/console -t btree -f num_set_exmpl.json -g` |
| `make btree graph=1` | `bin/console -t btree -g` |

The last example uses the numbers from -100 to 100 and capacity 3.

## Number set files

A number set file is a JSON array with one set of numbers.
This is how the start of `media/number-sets/num_set_exmpl.json` looks.

```json
[1, 6, 9, 11, 5, 3, 37, 20, 16, 17, 18, 40, 45, 12, 10, 8, 15, 30]
```

Put your own file next to it and pass only the file name to `-f`.
Git ignores your own files in this folder, so they stay on your machine.

## Composer

make has already installed the PHP packages into `vendor/`.
If you change `composer.json`, run `composer update` here.
It updates `composer.lock` and installs the new packages.

## Leave the container

Run `exit` or press `Ctrl+D`.
The container is removed when you leave it. Your files stay.

## Run without Docker

You can also run the same commands without Docker.
For that you need PHP 8.3 or newer, Composer and Graphviz on your machine.
PHP also needs the dom, simplexml and xml extensions. On Debian or Ubuntu they come with the `php8.3-xml` package.
Run the commands from the project root.

```bash
composer install
bin/console -t btree -c 3 -s "1, 2, 3, 4, 5, 6" -g -d
```

Graphviz gives the `dot` command that draws the picture.
Without it `-g` stops with an error like `sh: 1: dot: not found` and leaves an empty picture file in `media/graph`.
Install it with your package manager, for example `sudo apt install graphviz` on Debian or Ubuntu
or `brew install graphviz` on macOS. Other systems are on the [Graphviz download page](https://graphviz.org/download/).

Your local PHP may print `Deprecated` and `Notice` lines.
They are harmless, and the Docker image hides them.
