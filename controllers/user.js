const db = require('../models')
const User = db.User
const bcrypt = require('bcrypt')

const userController = {
  signup: (req, res) => {
    res.render('signup', {
      username: req.session.username,
      errorMessage: req.flash('errorMessage')
    })
  },

  handleSignup: (req, res, next) => {
    const saltRounds = 10
    const {username, password, nickname} = req.body
    if (!username || !password || !nickname) {
      req.flash('errorMessage', '啊...有東西沒填喔')
      return next()
    }

    bcrypt.hash(password, saltRounds, function(err, hash) {
      if (err) {
        req.flash('errorMessage', err.toString())
        return next()
      }
      
      User.findOne({
        where: {
          username,
        },
      }).then((user) => {
        if (user === null || user.username !== username) {
          User.create({
            username,
            password: hash,
            nickname
          }).then(() => {
            // 把 username 存進 SESSION 中，維持登入狀態，並重新導向
            req.session.username = username;
            res.redirect('/')
          }).catch((err2) => {
            req.flash('errorMessage', err2.toString())
            return next()
          })
        } else {
          req.flash('errorMessage', '使用者已存在')
          return next();
        }
      })
    })
  },

  login: (req,res) => {
    res.render('login', {
      username: req.session.username,
      errorMessage: req.flash('errorMessage')
    })
  },


  handleLogin: (req, res, next) => {
    const {username, password} = req.body
    if (!username || !password) {
      req.flash('errorMessage', '啊...有東西沒填喔')
      return next()
    }

    User.findOne({
      where: {
        username,
      },
    }).then(user => {
      bcrypt.compare(password, user.password, (err, isScuccess) => {
        if (err || !isScuccess) {
          req.flash('errorMessage', '密碼錯誤')
          return next()
        }
        req.session.username = user.username
        res.redirect('/')
      })
    }).catch(err => {
      req.flash('errorMessage', err.toString())
      return next()
    })
  },

  logout: (req, res) => {
    req.session.username = null
    res.redirect('/')
  }
}

module.exports = userController