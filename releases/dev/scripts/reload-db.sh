#!/bin/sh

echo
echo "WARNING:"
echo
echo "You probably do not want to run this script !!!"
echo
echo "If you really know what you are doing then remove the 'exit' line from the file"
echo
exit

SDIR=`dirname $0`/..

$SDIR/symfony doctrine:drop-db && $SDIR/symfony doctrine:create-db && $SDIR/symfony doctrine:migrate && $SDIR/symfony doctrine:data-load
