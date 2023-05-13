using System;
using System.Collections;
using System.Collections.Generic;
using System.Text;
namespace Jamiya
{
    #region Galleries
    public class Galleries
    {
        #region Member Variables
        protected int _id;
        protected string _title;
        protected unknown _date;
        protected string _image;
        protected string _status;
        protected unknown _created_at;
        protected unknown _updated_at;
        #endregion
        #region Constructors
        public Galleries() { }
        public Galleries(string title, unknown date, string image, string status, unknown created_at, unknown updated_at)
        {
            this._title=title;
            this._date=date;
            this._image=image;
            this._status=status;
            this._created_at=created_at;
            this._updated_at=updated_at;
        }
        #endregion
        #region Public Properties
        public virtual int Id
        {
            get {return _id;}
            set {_id=value;}
        }
        public virtual string Title
        {
            get {return _title;}
            set {_title=value;}
        }
        public virtual unknown Date
        {
            get {return _date;}
            set {_date=value;}
        }
        public virtual string Image
        {
            get {return _image;}
            set {_image=value;}
        }
        public virtual string Status
        {
            get {return _status;}
            set {_status=value;}
        }
        public virtual unknown Created_at
        {
            get {return _created_at;}
            set {_created_at=value;}
        }
        public virtual unknown Updated_at
        {
            get {return _updated_at;}
            set {_updated_at=value;}
        }
        #endregion
    }
    #endregion
}