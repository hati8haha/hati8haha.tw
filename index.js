const express = require('express')
const bodyParser = require('body-parser')
const session = require('express-session')
const flash = require('connect-flash');
const bcrypt = require('bcryptjs')
const app = express()
const port = 5001
const db = require('./models')

const userController = require('./controllers/user')
const articleController = require('./controllers/article')
const categoryController = require('./controllers/category')

app.set('view engine', 'ejs')

app.use(session({
  secret: process.env.SECRECT,
  resave: false,
  saveUninitialized: true
}))
app.use(bodyParser.urlencoded({ extended: false }))
app.use(bodyParser.json())
app.use(flash())
app.use(express.static(__dirname + '/public'));

function redirectBack(req, res) {
  res.redirect('back')
}

app.get('/', articleController.index)
app.get('/login', userController.login)
app.get('/signup', userController.signup)
app.get('/manage', articleController.manage)
app.get('/edit', articleController.edit, redirectBack)
app.get('/category', categoryController.getAll)
app.get('/article/:id', articleController.article)
app.get('/edit/:id', articleController.update, redirectBack)
app.get('/article/:id', articleController.article)
app.get('/logout', userController.logout)
app.get('/category/delete/:id', categoryController.delete)
app.get('/article/delete/:id', articleController.delete, redirectBack)
app.get('/articles/category/:id', articleController.articlesByCategory)
app.get('/page/:page', articleController.page, redirectBack)

app.post('/signup', userController.handleSignup, redirectBack)
app.post('/login', userController.handleLogin, redirectBack)
app.post('/edit', articleController.handleEdit, redirectBack)
app.post('/edit/:id', articleController.handleUpdate, redirectBack)
app.post('/category/new', categoryController.add, redirectBack)


app.listen(port, () => {
  console.log(`Example app listening on port ${port}!`)
})
