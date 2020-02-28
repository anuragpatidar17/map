var nodemailer = require('nodemailer');
var mysql = require('mysql');

var con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password:"",
   database:"webscrap",
 
  });
 

  con.connect(function(err) {
    if (err) throw err;
    console.log("Connected!");})

  var emails = 'SELECT email FROM mail';
var to_list = []
con.query(emails, function(err, email, fields){
  
  for(k in email){
      to_list.push(email[k].email)
    }
}); 


var transporter = nodemailer.createTransport({
  service: 'gmail',
 auth: {
    user: 'anuragpatidar17@gmail.com',
    pass: 'Version@5.0'
  }
});

var mailOptions = {
  from: 'anuragpatidar17@gmail.com',
  to: to_list,
  subject: 'Sending Email using Node.js',
  text: 'That was easy!'
};

transporter.sendMail(mailOptions, function(error, info){
  if (error) {
    console.log(error);
  } else {
    console.log('Email sent: ' + info.response);
  }
});
