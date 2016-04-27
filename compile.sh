#!/bin/sh

CWD=$(pwd)

echo $CWD

rm -rf $CWD/build

mkdir $CWD/build

BDIR=$CWD/build

cd  $CWD/com_rrlogin/

zip -r $BDIR/com_rrlogin.zip *


cd  $CWD/mod_rrlogin/

zip -r $BDIR/mod_rrlogin.zip *

cd  $CWD/libraries/rrlogin/

zip -r $BDIR/lib_rrlogin_oauth.zip *

cd  $CWD/libraries/amcharts/

zip -r $BDIR/lib_amcharts.zip *

cd  $CWD/plugins/user/rrlogin/

zip -r $BDIR/plg_rrlogin.zip *     

cd  $CWD/plugins/rrlogin_integration/profile/

zip -r $BDIR/plg_rrlogin_profile.zip * 

cd  $CWD/plugins/authentication/rrlogin

zip -r $BDIR/plg_authentication_rrlogin.zip *

cd  $CWD/plugins/rrlogin_auth/rrnetwork

zip -r $BDIR/plg_RL_rrnetwork.zip *

cd $CWD

cp pkg_rrlogin.xml $BDIR/
cp script.php $BDIR/
cd $BDIR

zip -r pkg_rrlogin.zip *
