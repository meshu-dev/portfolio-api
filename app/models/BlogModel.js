const mongoose = require('mongoose');

let Schema = mongoose.Schema;

let blogSchema = new Schema(
  {
    title: {
      type: String,
      unique: false,
      required: true,
    },
    url: {
      type: String,
      unique: false,
      required: true,
    },
    thumbUrl: {
      type: String,
      unique: false,
      required: true,
    },
  },
  {
    timestamps: true,
  }
);

blogSchema.set('toJSON', {
  versionKey: false,
});

blogSchema.options.toJSON.transform = (doc, ret) => {
  ret.createdAt = new Date(ret.createdAt).toString();
  ret.updatedAt = new Date(ret.updatedAt).toString();

  let idObj = {id: ret._id};
  delete ret._id;

  return Object.assign({}, idObj, ret);
};

module.exports = mongoose.model('Blog', blogSchema);
