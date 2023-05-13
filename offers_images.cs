using System;
using System.Collections;
using System.Collections.Generic;
using System.Text;
namespace Jamiya
{
    #region Offers_images
    public class Offers_images
    {
        #region Member Variables
        protected int _id;
        protected int _offers_id;
        protected string _image;
        #endregion
        #region Constructors
        public Offers_images() { }
        public Offers_images(int offers_id, string image)
        {
            this._offers_id=offers_id;
            this._image=image;
        }
        #endregion
        #region Public Properties
        public virtual int Id
        {
            get {return _id;}
            set {_id=value;}
        }
        public virtual int Offers_id
        {
            get {return _offers_id;}
            set {_offers_id=value;}
        }
        public virtual string Image
        {
            get {return _image;}
            set {_image=value;}
        }
        #endregion
    }
    #endregion
}