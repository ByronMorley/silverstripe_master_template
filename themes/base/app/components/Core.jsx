import React from 'react';
import Postal from 'postal';
import '../less/styles.less';

const dom_ready = Postal.channel('dom-ready');

class Core extends React.Component {

    constructor(props) {
        super(props);
        this.init();
    }
    init(){
        dom_ready.publish('dom-ready', {});
    }
}
export default Core;