using System;
using System.Collections;
using System.Collections.Generic;
using System.Text;
namespace Jamiya
{
    #region Jamaiya_products
    public class Jamaiya_products
    {
        #region Member Variables
        protected int _id;
        protected string _ItemBarcode;
        protected string _ItemCode;
        protected string _ItemName;
        protected string _ItemPrice;
        protected string _vendor;
        #endregion
        #region Constructors
        public Jamaiya_products() { }
        public Jamaiya_products(string ItemBarcode, string ItemCode, string ItemName, string ItemPrice, string vendor)
        {
            this._ItemBarcode=ItemBarcode;
            this._ItemCode=ItemCode;
            this._ItemName=ItemName;
            this._ItemPrice=ItemPrice;
            this._vendor=vendor;
        }
        #endregion
        #region Public Properties
        public virtual int Id
        {
            get {return _id;}
            set {_id=value;}
        }
        public virtual string ItemBarcode
        {
            get {return _ItemBarcode;}
            set {_ItemBarcode=value;}
        }
        public virtual string ItemCode
        {
            get {return _ItemCode;}
            set {_ItemCode=value;}
        }
        public virtual string ItemName
        {
            get {return _ItemName;}
            set {_ItemName=value;}
        }
        public virtual string ItemPrice
        {
            get {return _ItemPrice;}
            set {_ItemPrice=value;}
        }
        public virtual string Vendor
        {
            get {return _vendor;}
            set {_vendor=value;}
        }
        #endregion
    }
    #endregion
}