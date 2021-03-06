class BlogController {
  constructor(blogModel) {
    this.blogModel = blogModel;
  }
  async create(req, res) {
    let data = {
      title: req.body.title,
      url: req.body.url,
      thumbUrl: req.body.thumbUrl,
    };
    let blog = await this.blogModel(data).save();
    res.json(blog);
  }
  async read(req, res) {
    let blog = await this.blogModel.find({_id: req.params.id});
    res.json(blog[0] ? blog[0] : {});
  }
  async readRows(req, res) {
    let params = req.query,
      options = {
        skip: params.skip ? parseInt(params.skip) : 0,
        limit: params.limit ? parseInt(params.limit) : 10,
      };

    if (params.sort) {
      let sortFlag = params.sort === 'asc' ? 1 : -1;
      options.sort = {createdAt: sortFlag};
    }

    let blogs = await this.blogModel.find({}, null, options),
      total = await this.blogModel.countDocuments({});

    res.setHeader('X-Total-Count', total);
    res.json(blogs);
  }
  async update(req, res) {
    let data = {
      title: req.body.title,
      url: req.body.url,
      thumbUrl: req.body.thumbUrl,
    };
    let blog = await this.blogModel.findOneAndUpdate(
      {_id: req.params.id},
      {$set: data},
      {new: true}
    );
    res.json(blog);
  }
  async delete(req, res) {
    await this.blogModel.findOneAndDelete({_id: req.params.id});
    res.json({});
  }
}

module.exports = BlogController;
