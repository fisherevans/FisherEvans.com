'use strict';
//console.log('Loading function');
exports.handler = (event, context, callback) => {
    //console.log('Received event:', JSON.stringify(event, null, 2));
    var redirect = process.env.redirectBase + event.path;
    //console.log('Redirecting to: ' + redirect);
    callback(null, {
        statusCode: '302',
        headers: {
            'Location': redirect
        },
    });
};
