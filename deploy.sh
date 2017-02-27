#!/usr/bin/env bash
#
# release.sh
#
# Takes a tag to release, and syncs it to WordPress.org
#
# Based on https://github.com/toolstack/git-to-wp-plugin-dir-release-script
# Added comparability with Windows Git Bash based on MinGW
#
# Usage:
# ./release.sh tag svn-username svn-password
#


TAG=$1
USERNAME=$2
PASSWORD=$3

PLUGIN="ram108-typo"
TMPDIR=./tmp
PLUGINDIR="$PWD"
PLUGINSVN="https://plugins.svn.wordpress.org/$PLUGIN"
TMPTAR="tmp.tar"

# Fail on any error
set -e

# Is the tag valid?
if [ -z "$TAG" ] || ! git rev-parse "$TAG" > /dev/null; then
	echo "Invalid tag. Make sure you tag before trying to release."
	exit 1
fi

# Username
if [ -z "$USERNAME" ]; then
	echo "Empty Wordpress SVN username"
	exit 1
fi

# Password
if [ -z "$PASSWORD" ]; then
	echo "Empty Wordpress SVN password"
	exit 1
fi


if [[ ${TAG} == "v*" ]]; then
	# Starts with an extra "v", strip for the version
	VERSION=${TAG:1}
else
	VERSION="$TAG"
fi

if [ -d "$TMPDIR" ]; then
	# Wipe it clean
	rm -r "$TMPDIR"
fi

# Ensure the directory exists first
mkdir "$TMPDIR"

# Grab an unadulterated copy of SVN
svn co "$PLUGINSVN/trunk" "$TMPDIR" > /dev/null

# Extract files from the Git tag to temporary tar file
git archive --format="tar" "$TAG" > "$TMPTAR"
# Move temporary tar file to build dir
mv "$TMPTAR" "$TMPDIR/$TMPTAR"
# Switch to build dir
cd "$TMPDIR"
# Extract files
tar -xf "$TMPTAR"
# Remove temporary tar
rm "$TMPTAR"

# Run build tasks
#sed -e "s/{{TAG}}/$VERSION/g" < "$PLUGINDIR/bin/readme.txt" > readme.txt

# Remove special files
#rm ".gitignore"
#rm ".scrutinizer.yml"
#rm ".travis.yml"
#rm "composer.json"
#rm "Gruntfile.js"
#rm "package.json"
#rm "phpcs.ruleset.xml"
#rm "phpunit.xml.dist"
#rm "multisite.xml"
#rm "codecoverage.xml"
#rm -r "assets"
#rm -r "bin"
#rm -r "tests"

# Add any new files
#svn status | grep -v "^.[ \t]*\..*" | grep "^?" | awk '{print $2}' | xargs svn add
svn add --force .

# Pause to allow checking
echo "About to commit $VERSION. Double-check $TMPDIR to make sure everything looks fine."
read -p "Hit Enter to continue."
# Commit the changes
svn commit -m "Trunk $VERSION" --username ${USERNAME} --password ${PASSWORD}

# tag_ur_it
svn copy "$PLUGINSVN/trunk" "$PLUGINSVN/tags/$VERSION" -m "Tag $VERSION"

# Clean tmp dir
cd ..
rm -r "$TMPDIR"
