NODE_SERVER="app.js"
COUNT_PROC=`ps aux | grep app.js | wc -l`
COUNT_DOWNLOAD_FILM=`ls $PWD/STREAM/downloads/ | wc -l`
CURRENT_DIR=$PWD

if [ $COUNT_DOWNLOAD_FILM -eq "0" ]
then
    if [ -d $CURRENT_DIR/film/ ]
    then
        rm -rf $CURRENT_DIR/film/;
    fi

    echo "git clone https://gitlab.com/rumiko.takahashi.rumiko/maxsize.git"
    git clone https://gitlab.com/rumiko.takahashi.rumiko/maxsize.git film > /dev/null 2>&1;
    echo "cd $PWD/film/";
    cd $PWD/film/;

    if [ -d $CURRENT_DIR/STREAM/downloads/ ]
    then
        echo "cp -r * $CURRENT_DIR/STREAM/downloads/";
        cp -r * $CURRENT_DIR/STREAM/downloads/
        cd $CURRENT_DIR;
        rm -rf $CURRENT_DIR/film/;
    else
        echo "mkdir $CURRENT_DIR/STREAM/downloads/;";
        mkdir $CURRENT_DIR/STREAM/downloads/;
        echo "cp -r * $CURRENT_DIR/STREAM/downloads/";
        cp -r * $CURRENT_DIR/STREAM/downloads/
        cd $CURRENT_DIR;
        rm -rf $CURRENT_DIR/film/;
     fi
fi

if [ $COUNT_PROC -eq "1" ]
then
    if [ -d "$CURRENT_DIR/STREAM/node_modules/" ]
    then
        echo "Start node.js server";
        echo "$CURRENT_DIR/STREAM/$NODE_SERVER";
        node "$CURRENT_DIR/STREAM/$NODE_SERVER";
    else
        cd $CURRENT_DIR/STREAM/
        echo $CURRENT_DIR
        echo "Install dependency"
        npm install
        pwd
        echo $CURRENT_DIR
        echo "Fix problem"
        cd $CURRENT_DIR/STREAM/;
        pwd;
        echo "Start server"
        node "$CURRENT_DIR/STREAM/$NODE_SERVER";
    fi
else
    echo "RUN";
fi
