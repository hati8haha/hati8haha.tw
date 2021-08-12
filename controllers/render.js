const db = require('../models')
const Article = db.Article
const Category = db.Category

const renderController = {
  // index: (req, res) => {
  //   res.render('main', {
  //     username: req.session.username
  //   })
  // },

  // login: (req,res) => {
  //   res.render('login', {
  //     username: req.session.username,
  //     errorMessage: req.flash('errorMessage')
  //   })
  // },

  // manage: (req, res) => {
  //   res.render('manage', {
  //     username: req.session.username,
  //     errorMessage: req.flash('errorMessage')
  //   })
  // },

  // edit: (req, res, next) => {
  //   res.render('edit', {
  //     update: false,
  //     username: req.session.username,
  //     errorMessage: req.flash('errorMessage'),
  //     id: null,
  //     title: null,
  //     content: null
  //   })
  // },

  // update: (req, res, next) => {
  //   const id = req.params.id
  //   Article.findOne({
  //     where:{
  //       id
  //     }
  //   }).then((article) => {
  //     const title = article.title
  //     const content = article.content
  //     res.render('edit', {
  //       update: true,
  //       username: req.session.username,
  //       errorMessage: req.flash('errorMessage'),
  //       id,
  //       title,
  //       content,
  //     })
  //   }).catch((err) => {
  //     req.flash('errorMessage', err.toString())
  //     console.log(err)
  //     return next()
  //   })
  // },

  // article: (req, res) => {
  //   res.render('article', {
  //     username: req.session.username
  //   })
  // },

  // signup: (req, res) => {
  //   res.render('signup', {
  //     username: req.session.username,
  //     errorMessage: req.flash('errorMessage')
  //   })
  // },

  // category: (req, res) => {
  //   Category.findAll({
  //     where: {
  //       isDeleted: false
  //     }
  //   }).then(categories => {
  //     res.render('category', {
  //       username: req.session.username,
  //       errorMessage: req.flash('errorMessage'),
  //       categories
  //     })
  //   })
  //   // res.render('category', {
  //   //   username: req.session.username,
  //   //   errorMessage: req.flash('errorMessage')
  //   // })
  // }
}

module.exports = renderController