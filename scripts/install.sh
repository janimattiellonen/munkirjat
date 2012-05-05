#
# DGS mobile install script
#
# This script fetches all dependencies and also tries to download yuicompressor and Zend Framework libraries

root=../

## YuiCompressor

echo "Obtaining and installing yuicompressor..."

wget http://yui.zenfs.com/releases/yuicompressor/yuicompressor-2.4.7.zip && \
unzip yuicompressor-2.4.7.zip
rm yuicompressor-2.4.7.zip 


## create directories where compressed js and css files will be stored

echo "Creating directories for assetic dumps..."

jsPath=$root/public/assets/assetic/js
cssPath=$root/public/assets/assetic/css

mkdir -p $jsPath
mkdir -p $cssPath

chmod -R a+rw $jsPath
chmod -R a+rw $cssPath


## Zend Framework

echo "Obtaining and installing Zend Framework..."

wget http://framework.zend.com/releases/ZendFramework-1.11.11/ZendFramework-1.11.11.zip
unzip ZendFramework-1.11.11.zip
rm ZendFramework-1.11.11.zip

mv ZendFramework-1.11.11/library/Zend ../library/
mv ZendFramework-1.11.11/extras/library/ZendX ../library

rm -Rf ZendFramework-1.11.11

## Other dependencies in external directory

echo "Fetching dependencies...";

cd ../

git submodule update --init

